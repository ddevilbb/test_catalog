<?php

namespace App\Domains\Product\Providers;

use App\Domains\Product\Builders\ProductBuilder;
use App\Domains\Product\Entities\Product;
use App\Domains\Product\Services\ProductService;
use Illuminate\Support\ServiceProvider;

class ProductServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ProductService::class, function ($app) {
            return new ProductService($app->make('em'));
        });
        $this->app->singleton(ProductBuilder::class, function ($app) {
            return new ProductBuilder(($app->make('em'))->getRepository(Product::class));
        });
    }
}