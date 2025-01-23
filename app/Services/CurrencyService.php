<?php

namespace App\Services;

use App\Models\Currency;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class CurrencyService
{
    protected $currency_rate;

    public function __construct()
    {
        $this->currency_rate = session('sale_rate', 1);
    }

    public function fetchExchangeRates()
    {
        $xml = Http::get('https://bankdabrabyt.by/export_courses.php')->body();
        $data = simplexml_load_string($xml);
        $time = Carbon::createFromFormat('d.m.Y H:i', $data->time)->format('Y-m-d H:i:s');
        $currencies = ['USD', 'EUR', 'RUB'];
        foreach ($data->filials->filial[0]->rates->value as $rate) {
            if (in_array($rate['iso'], $currencies)) {
                Currency::updateOrCreate(
                    ['iso' => (string)$rate['iso']],
                    ['sale_rate' => (float)$rate['sale'], 'retrieved_at' => $time, 'is_main' => 0]
                );
            }
        }
    }

    public function convert($price)
    {
        return round($price / $this->currency_rate, 2);
    }
}
