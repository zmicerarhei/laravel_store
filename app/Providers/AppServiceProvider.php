<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ProductRepository;
use Illuminate\Support\Facades\View;
use App\Models\Category;
use App\Services\Interfaces\RepositoryInterface;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(RepositoryInterface::class, ProductRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (Schema::hasTable('categories')) {
            $categories = Category::all();
            View::share(
                [
                    'categories' => $categories
                ]
            );
        }

        Paginator::useBootstrapFour();
    }
}
