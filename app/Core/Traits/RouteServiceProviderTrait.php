<?php

namespace App\Core\Traits;

trait RouteServiceProviderTrait
{
    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        require $this->directory . '/../Http/routes.php';
    }
}