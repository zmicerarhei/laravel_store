<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\BankApiClientInterface;
use App\Contracts\CurrencyServiceInterface;
use App\Contracts\CurrencyRepositoryInterface;
use App\Contracts\ExchangeRatesServiceInterface;
use App\Models\Currency;
use App\Repositories\CurrencyRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class DabrabytCurrencyService implements CurrencyServiceInterface
{

    public function __construct(
        private BankApiClientInterface $bankApiClient,
        private ExchangeRatesServiceInterface $exchangeRatesService,
        private CurrencyRepositoryInterface $currencyRepository,
        private array $currency_types,
        private array $fallbackRates,
    ) {}

    public function updateExchangeRates(): void
    {
        // $data = $this->getExchangeRatesFromAPI();
        // $this->saveExchangeRatesToDatabase($data, config('currency.currencies'));

        try {
            $data = $this->exchangeRatesService->fetchExchangeRates();
        } catch (\Exception $e) {
            $data = $this->getDefaultRates();
        }

        foreach ($data['rates'] as $rate) {
            $iso = (string)$rate['iso'];

            if (in_array($iso, $this->currency_types, true)) {
                $this->currencyRepository->updateByIso($rate, $iso);
            }
        }
    }

    public function getCurrencies(): Collection
    {
        return Cache::remember('currencies', 600, function () {
            $this->updateExchangeRates();
            return $this->currencyRepository->all();
        });
    }

    public function convert(float $price): float
    {
        $currency_rate = session('sale_rate', 1);

        return round($price / $currency_rate, 2);
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
