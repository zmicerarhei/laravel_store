<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\BankApiClientInterface;
use App\Contracts\CurrencyServiceInterface;
use App\Models\Currency;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class DabrabytCurrencyService implements CurrencyServiceInterface
{
    protected float $currency_rate;

    public function __construct(protected BankApiClientInterface $bankApiClient)
    {
        $this->currency_rate = session('sale_rate', 1);
    }

    public function updateExchangeRates(): void
    {
        $data = $this->getExchangeRatesFromAPI();
        $this->saveExchangeRatesToDatabase($data, config('currency.currencies'));
    }

    public function getCurrencies(): Collection
    {
        return Cache::remember('currencies', 600, function () {
            $this->updateExchangeRates();
            return Currency::all();
        });
    }

    public function convert(float $price): float
    {
        return round($price / $this->currency_rate, 2);
    }

    /**
     * Get exchange rates from API.
     *
     * @param string $bankApi
     *
     * @return array{
     *     rates: array<int, array{iso: string, sale: string}>,
     * }
     */

    private function getExchangeRatesFromAPI(): array
    {
        try {
            $xml = $this->bankApiClient->fetchExchangeRates();
            $xmlObj = simplexml_load_string($xml);

            if (!$xmlObj || !isset($xmlObj->time)) {
                throw new \RuntimeException('Failed to load or parse XML from the bank API.');
            }

            $date = Carbon::createFromFormat('d.m.Y H:i', (string) $xmlObj->time);

            if (!$date) {
                throw new \RuntimeException('Invalid date format in the API response.');
            }

            $time = $date->format('Y-m-d H:i:s');
            $ratesArr = $this->parseRatesFromXMLtoArr($xmlObj);

            return [
                'rates' => $ratesArr,
            ];
        } catch (\Exception $e) {
            logger()->error('API request failed: ' . $e->getMessage());

            return $this->getDefaultRates();
        }
    }

    /**
     * Save exchange rates to database
     *
     * @param array{rates: array<int, array{iso: string, sale: string}>} $data
     * @param array<string> $currency_types
     */
    private function saveExchangeRatesToDatabase(array $data, array $currency_types): void
    {
        try {
            foreach ($data['rates'] as $rate) {
                $iso = (string)$rate['iso'];
                if (in_array($iso, $currency_types, true)) {
                    Currency::updateOrCreate(
                        ['iso' => $iso],
                        [
                            'sale_rate' => (float)$rate['sale'],
                            'is_main' => 0
                        ]
                    );
                }
            }
        } catch (\Exception $e) {
            throw new \Exception("Failed to save currency data: " . $e->getMessage());
        }
    }

    /**
     *  Parse rates from XML to array
     *
     * @param \SimpleXMLElement $xmlObj
     * @return array<int, array{iso: string, sale: string}>
     */
    private function parseRatesFromXMLtoArr($xmlObj): array
    {
        $json = json_encode($xmlObj->filials->filial[0]->rates)
            ?: throw new \RuntimeException('Failed to encode XML to JSON.');

        $rawRates = json_decode($json, true);
        if (!is_array($rawRates)) {
            throw new \RuntimeException('Failed to decode JSON to array.');
        }

        $cleanRates = [];
        foreach ($rawRates['value'] as $rate) {
            if (isset($rate['@attributes'])) {
                $cleanRates[] = [
                    'iso' => $rate['@attributes']['iso'],
                    'sale' => $rate['@attributes']['sale'],
                ];
            }
        }

        return $cleanRates;
    }

    /**
     *  Get default exchange rates
     *
     * @return array{
     *     rates: array<int, array{iso: string, sale: string}>,
     * }
     */
    private function getDefaultRates(): array
    {
        return [
            'rates' => config('currency.fallbackRates'),
        ];
    }
}
