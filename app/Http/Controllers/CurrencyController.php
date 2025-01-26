<?php

namespace App\Http\Controllers;

use App\Services\CurrencyService;

class CurrencyController extends Controller
{
    public function updateRates(CurrencyService $currencyService)
    {
        $currencyService->fetchExchangeRates();
        return back()->with('message', 'Rates have been updated.');
    }

    public function changeCurrency(string $iso, float $rate)
    {
        session(['currency_iso' => $iso, 'sale_rate' => $rate]);
        return redirect()->back();
    }
}
