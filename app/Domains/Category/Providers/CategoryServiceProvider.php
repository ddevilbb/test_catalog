<?php

namespace App\Domains\Category\Providers;

use App\Domains\Category\Builders\CategoryBuilder;
use App\Domains\Category\Entities\Category;
use App\Domains\Category\Services\CategoryService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class CategoryServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CategoryService::class, function ($app) {
            return new CategoryService(App::make('em'));
        });
        $this->app->singleton(CategoryBuilder::class, function ($app) {
            return new CategoryBuilder(($app->make('em'))->getRepository(Category::class));
        });
    }
}