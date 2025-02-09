<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\CurrencyServiceInterface;
use Illuminate\Http\RedirectResponse;

class CurrencyController extends Controller
{
    public function __construct(private CurrencyServiceInterface $currencyService)
    {
    }
    public function changeCurrency(string $iso, float $rate): RedirectResponse
    {
        $this->currencyService->setCurrencyToSession($iso, $rate);
        return redirect()->back();
    }
}
