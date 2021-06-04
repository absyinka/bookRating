<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register Interface and Repository in here
        // You must place Interface in first place
        // If you dont, the Repository will not get readed.

        $this->app->bind(
            'App\Interfaces\IAuthInterface',
            'App\Repositories\AuthRepository'
        );

        $this->app->bind(
            'App\Interfaces\IBookInterface',
            'App\Repositories\BookRepository'
        );

        $this->app->bind(
            'App\Interfaces\IRatingInterface',
            'App\Repositories\RatingRepository'
        );

    }
}
