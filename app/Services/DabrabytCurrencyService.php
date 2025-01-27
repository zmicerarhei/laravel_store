<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\CurrencyServiceInterface;
use App\Models\Currency;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class DabrabytCurrencyService implements CurrencyServiceInterface
{
    protected float $currency_rate;

    public function __construct()
    {
        $this->currency_rate = session('sale_rate', 1);
    }

    public function fetchExchangeRates(): void
    {
        $data = $this->getExchangeRatesFromAPI(config('currency.api_url'));
        $this->saveExchangeRatesToDatabase($data, config('currency.currencies'));
    }

    /**
     * @return array{rates: \SimpleXMLElement, retrieved_at: string}
     */
    private function getExchangeRatesFromAPI(string $bankApi): array
    {
        $xml = Http::get($bankApi)->body();
        $data = simplexml_load_string($xml);

        if (!$data || !isset($data->time)) {
            throw new \RuntimeException('Failed to load or parse XML from the bank API.');
        }

        $date = Carbon::createFromFormat('d.m.Y H:i', (string) $data->time);

        if (!$date) {
            throw new \RuntimeException('Invalid date format in the API response.');
        }

        $time = $date->format('Y-m-d H:i:s');

        return [
            'rates' => $data->filials->filial[0]->rates->value,
            'retrieved_at' => $time,
        ];
    }

    /**
     * Save exchange rates to database
     *
     * @param array{rates: \SimpleXMLElement, retrieved_at: string} $data Exchange rates data from API
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

    public function convert(float $price): float
    {
        return round($price / $this->currency_rate, 2);
    }
}
