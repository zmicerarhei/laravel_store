<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Contracts\CurrencyRepositoryInterface;
use App\Contracts\ProductRepositoryInterface;
use App\Contracts\CategoryRepositoryInterface;
use App\Contracts\CurrencyServiceInterface;
use App\Contracts\ClientProductServiceInterface;
use App\Contracts\AdminProductServiceInterface;
use App\Contracts\RegisterServiceInterface;
use App\Contracts\BankApiClientInterface;
use App\Contracts\ExchangeRatesServiceInterface;
use App\Contracts\ProductFilterInterface;
use App\Contracts\UserRepositoryInterface;
use App\Clients\BankApiClient;
use App\Contracts\BrandRepositoryInterface;
use App\Contracts\CsvWriterInterface;
use App\Filters\ProductFilter;
use App\Services\AdminProductService;
use App\Services\DabrabytCurrencyService;
use App\Services\ClientProductService;
use App\Services\RegisterService;
use App\Repositories\CategoryRepository;
use App\Repositories\BrandRepository;
use App\Repositories\CurrencyRepository;
use App\Repositories\ProductRepository;
use App\Repositories\UserRepository;
use App\Http\Middleware\SetDefaultDataToSession;
use App\Services\ExchangeRatesService;
use App\Utils\CarbonClock;
use App\Utils\CsvWriterAdapter;
use Psr\Clock\ClockInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductFilterInterface::class, ProductFilter::class);
        $this->app->bind(CurrencyRepositoryInterface::class, CurrencyRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(BrandRepositoryInterface::class, BrandRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(CurrencyServiceInterface::class, DabrabytCurrencyService::class);
        $this->app->bind(ExchangeRatesServiceInterface::class, ExchangeRatesService::class);
        $this->app->bind(ClientProductServiceInterface::class, ClientProductService::class);
        $this->app->bind(AdminProductServiceInterface::class, AdminProductService::class);
        $this->app->bind(RegisterServiceInterface::class, RegisterService::class);
        $this->app->bind(BankApiClientInterface::class, BankApiClient::class);
        $this->app->bind(SetDefaultDataToSession::class, function ($app) {
            return new SetDefaultDataToSession(
                config('currency.default.iso'),
                config('currency.default.sale_rate')
            );
        });
        $this->app->bind(StatefulGuard::class, function ($app) {
            return Auth::guard('web');
        });

        $this->app->singleton(BankApiClientInterface::class, function () {

            return new BankApiClient(config('currency.api_url'));
        });

        $this->app->singleton(DabrabytCurrencyService::class, function ($app) {

            return new DabrabytCurrencyService(
                $app->make(ExchangeRatesServiceInterface::class),
                $app->make(CurrencyRepositoryInterface::class),
                config('currency.currencies'),
                config('currency.fallbackRates'),
            );
        });
        $this->app->singleton(ClockInterface::class, function ($app) {
            return new CarbonClock();
        });

        $this->app->singleton(CsvWriterInterface::class, function ($app) {
            return new CsvWriterAdapter();
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
