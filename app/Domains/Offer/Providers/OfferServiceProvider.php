<?php

namespace App\Domains\Offer\Providers;

use App\Domains\Offer\Builders\OfferBuilder;
use App\Domains\Offer\Entities\Offer;
use App\Domains\Offer\Services\OfferService;
use Illuminate\Support\ServiceProvider;

class OfferServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(OfferBuilder::class, function ($app) {
            return new OfferBuilder(($app->make('em')->getRepository(Offer::class)));
        });
    }
}