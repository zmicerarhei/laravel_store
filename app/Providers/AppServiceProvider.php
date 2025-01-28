<?php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\CurrencyServiceInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\ProductRepository;
use App\Contracts\RepositoryInterface;
use App\Services\DabrabytCurrencyService;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(RepositoryInterface::class, ProductRepository::class);
        $this->app->bind(CurrencyServiceInterface::class, DabrabytCurrencyService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (!(session()->has('currency_iso'))) {
            session()->put('currency_iso', config('currency.default.iso'));
            session()->put('sale_rate', config('currency.default.sale_rate'));
        }

        Paginator::useBootstrapFour();
    }
}
