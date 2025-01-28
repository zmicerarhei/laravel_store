<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Currency;
use Illuminate\Support\Facades\Cache;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer(['catalog.index'], function ($view) {
            $view->with('brands', Brand::pluck('name')->all());
        });

        View::composer(['layouts.main'], function ($view) {

            $currencies = Cache::remember('currencies', 600, function () {
                return Currency::all();
            });
            $view->with('categories', Category::all());
            $view->with('currencies', $currencies);
        });
    }
}
