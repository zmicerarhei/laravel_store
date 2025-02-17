<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\ProductRepositoryInterface;
use App\Contracts\CurrencyServiceInterface;
use App\Contracts\CategoryServiceInterface;
use App\Contracts\ClientProductServiceInterface;
use App\Contracts\AdminProductServiceInterface;
use App\Contracts\BankApiClientInterface;
use App\Repositories\ProductRepository;
use App\Clients\BankApiClient;
use App\Services\AdminProductService;
use App\Services\CategoryService;
use App\Services\DabrabytCurrencyService;
use App\Services\ClientProductService;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(CurrencyServiceInterface::class, DabrabytCurrencyService::class);
        $this->app->bind(CategoryServiceInterface::class, CategoryService::class);
        $this->app->bind(ClientProductServiceInterface::class, ClientProductService::class);
        $this->app->bind(AdminProductServiceInterface::class, AdminProductService::class);
        $this->app->bind(BankApiClientInterface::class, BankApiClient::class);

        $this->app->singleton(BankApiClientInterface::class, function () {
            $apiUrl = config('currency.api_url');

            return new BankApiClient($apiUrl);
        });
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
