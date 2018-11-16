<?php

namespace App\Applications\Catalog\Providers;

use App\Core\Traits\RouteServiceProviderTrait;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\View;

class RouteServiceProvider extends ServiceProvider
{
    use RouteServiceProviderTrait;

    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Applications\Catalog\Http\Controllers';

    /**
     * @var string
     */
    protected $directory = __DIR__;

    public function boot()
    {
        parent::boot();

        View::composer(
            '*', 'App\Applications\Catalog\Http\Composers\CatalogComposer'
        );
    }
}