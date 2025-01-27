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

    private function getExchangeRatesFromAPI(string $bankApi): array
    {
        $xml = Http::get($bankApi)->body();
        $data = simplexml_load_string($xml);

        $time = Carbon::createFromFormat('d.m.Y H:i', $data->time)->format('Y-m-d H:i:s');

        return [
            'rates' => $data->filials->filial[0]->rates->value,
            'retrieved_at' => $time,
        ];
    }

    private function saveExchangeRatesToDatabase(array $data, array $currency_types): void
    {
        foreach ($data['rates'] as $rate) {
            if (in_array($rate['iso'], $currency_types)) {
                Currency::updateOrCreate(
                    ['iso' => (string)$rate['iso']],
                    ['sale_rate' => (float)$rate['sale'], 'retrieved_at' => $data['retrieved_at'], 'is_main' => 0]
                );
            }
        }
    }

    public function convert(float $price): float
    {
        return round($price / $this->currency_rate, 2);
    }
}
