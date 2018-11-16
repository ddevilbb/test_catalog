<?php

namespace App\Core\Providers;

use App\Core\Services\DoctrineService;
use App\Core\Services\ImportFromJsonService;
use App\Domains\Category\Builders\CategoryBuilder;
use App\Domains\Offer\Builders\OfferBuilder;
use App\Domains\Product\Builders\ProductBuilder;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(DoctrineService::class, function ($app) {
            return new DoctrineService($app->make('em'));
        });
        $this->app->singleton(ImportFromJsonService::class, function ($app) {
            return new ImportFromJsonService(
                $app->make(Client::class),
                $app->make(DoctrineService::class),
                $app->make(ProductBuilder::class),
                $app->make(CategoryBuilder::class),
                $app->make(OfferBuilder::class)
            );
        });
    }
}
