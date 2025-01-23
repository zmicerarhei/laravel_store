<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Currency;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        View::creator(['catalog.index'], function ($view) {
            $view->with('brands', Brand::all()->pluck('name'));
        });

        View::creator(['layouts.main', 'catalog.index'], function ($view) {
            $view->with('categories', Category::all());
            $view->with('currencies', Currency::all());
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
