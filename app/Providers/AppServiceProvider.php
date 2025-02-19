<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\ProductRepositoryInterface;
use App\Contracts\CurrencyServiceInterface;
use App\Contracts\ClientProductServiceInterface;
use App\Contracts\AdminProductServiceInterface;
use App\Contracts\AuthServiceInterface;
use App\Contracts\BankApiClientInterface;
use App\Contracts\CategoryRepositoryInterface;
use App\Clients\BankApiClient;
use App\Http\Middleware\SetDefaultDataToSession;
use App\Services\AdminProductService;
use App\Services\DabrabytCurrencyService;
use App\Services\ClientProductService;
use App\Services\AuthService;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(CurrencyServiceInterface::class, DabrabytCurrencyService::class);
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
            $apiUrl = config('currency.api_url');

            return new BankApiClient($apiUrl);
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
