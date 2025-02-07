<?php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\CurrencyServiceInterface;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Brand;
use App\Models\Category;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void {}

    /**
     * Bootstrap services.
     */
    public function boot(CurrencyServiceInterface $currencyService): void
    {
        View::composer(['catalog.index'], function ($view) {
            $view->with('brands', Brand::pluck('name')->all());
        });

        View::composer(['layouts.main'], function ($view) use ($currencyService) {
            $currencies = $currencyService->getCurrencies();
            $view->with('categories', Category::all());
            $view->with('currencies', $currencies);
        });
    }
}
