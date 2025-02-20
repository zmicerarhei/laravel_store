<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Contracts\CurrencyRepositoryInterface;
use App\Contracts\ProductRepositoryInterface;
use App\Contracts\CategoryRepositoryInterface;
use App\Contracts\CurrencyServiceInterface;
use App\Contracts\ClientProductServiceInterface;
use App\Contracts\AdminProductServiceInterface;
use App\Contracts\AuthServiceInterface;
use App\Contracts\BankApiClientInterface;
use App\Clients\BankApiClient;
use App\Contracts\ExchangeRatesServiceInterface;
use App\Services\AdminProductService;
use App\Services\DabrabytCurrencyService;
use App\Services\ClientProductService;
use App\Services\AuthService;
use App\Repositories\CategoryRepository;
use App\Repositories\CurrencyRepository;
use App\Repositories\ProductRepository;
use App\Http\Middleware\SetDefaultDataToSession;
use App\Services\ExchangeRatesService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BankApiClientInterface::class, BankApiClient::class);
        $this->app->bind(CurrencyRepositoryInterface::class, CurrencyRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(CurrencyServiceInterface::class, DabrabytCurrencyService::class);
        $this->app->bind(ExchangeRatesServiceInterface::class, ExchangeRatesService::class);
        $this->app->bind(ClientProductServiceInterface::class, ClientProductService::class);
        $this->app->bind(AdminProductServiceInterface::class, AdminProductService::class);
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(BankApiClientInterface::class, BankApiClient::class);
        $this->app->bind(SetDefaultDataToSession::class, function ($app) {
            return new SetDefaultDataToSession(
                config('currency.default.iso'),
                config('currency.default.sale_rate')
            );
        });

        $this->app->singleton(BankApiClientInterface::class, function () {

            return new BankApiClient(config('currency.api_url'));
        });

        $this->app->singleton(DabrabytCurrencyService::class, function ($app) {

            return new DabrabytCurrencyService(
                $app->make(BankApiClientInterface::class),
                $app->make(ExchangeRatesServiceInterface::class),
                $app->make(CurrencyRepositoryInterface::class),
                config('currency.currencies'),
                config('currency.fallbackRates')
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFour();
    }
}
