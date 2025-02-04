<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\CurrencyServiceInterface;
use App\Models\Currency;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DabrabytCurrencyService implements CurrencyServiceInterface
{
    protected float $currency_rate;

    public function __construct()
    {
        $this->currency_rate = session('sale_rate', 1);
    }

    public function updateExchangeRates(): void
    {
        $data = $this->getExchangeRatesFromAPI(config('currency.api_url'));
        $this->saveExchangeRatesToDatabase($data, config('currency.currencies'));
    }

    /**
     * Получает курсы валют с API банка.
     *
     * @param string $bankApi URL банка для получения курсов валют.
     *
     * @return array{
     *     rates: array<int, array{iso: string, sale: string}>,
     *     retrieved_at: string
     * }
     */
    private function getExchangeRatesFromAPI(string $bankApi): array
    {
        try {
            $xml = Http::get($bankApi)->body();
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
                'retrieved_at' => $time,
            ];
        } catch (\Exception $e) {
            Log::error('API request failed: ' . $e->getMessage());
            return $this->getDefaultRates();
        }
    }

    /**
     * Save exchange rates to database
     *
     * @param array{rates: array<int, array{iso: string, sale: string}>, retrieved_at: string} $data
     * @param array<string> $currency_types Array of currency ISO codes to process
     * @throws \Exception When unable to save currency data
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
                            'retrieved_at' => $data['retrieved_at'],
                            'is_main' => 0
                        ]
                    );
                }
            }
        } catch (\Exception $e) {
            throw new \Exception("Failed to save currency data: " . $e->getMessage());
        }
    }

    public function getCurrencies(): Collection
    {
        return Cache::remember('currencies', 600, function () {
            $this->updateExchangeRates();
            return Currency::all();
        });
    }

    /**
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
     * @return array{
     *     rates: array<int, array{iso: string, sale: string}>,
     *     retrieved_at: string
     * }
     */
    private function getDefaultRates(): array
    {
        return [
            'rates' => config('currency.fallbackRates'),
            'retrieved_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ];
    }

    public function convert(float $price): float
    {
        return round($price / $this->currency_rate, 2);
    }
}
