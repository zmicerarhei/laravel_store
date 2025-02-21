<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\CurrencyServiceInterface;
use Illuminate\Http\RedirectResponse;

class CurrencyController extends Controller
{
    public function changeCurrency(string $iso, float $rate): RedirectResponse
    {
        session(['currency_iso' => $iso, 'sale_rate' => $rate]);

        return redirect()->back();
    }
}
