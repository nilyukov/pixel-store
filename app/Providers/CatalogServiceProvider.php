<?php

namespace App\Providers;

use App\Filters\BrandsFilter;
use App\Filters\PriceFilter;
use Domain\Catalog\Filters\FilterManager;
use Domain\Catalog\Sorters\Sorter;
use Illuminate\Support\ServiceProvider;

class CatalogServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(FilterManager::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        app(FilterManager::class)->registerFilters([
            new PriceFilter(),
            new BrandsFilter()
        ]);

        app()->bind(Sorter::class, function () {
            return new Sorter([
                'title',
                'price'
            ]);
        });
    }
}