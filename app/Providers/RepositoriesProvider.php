<?php

namespace App\Providers;

use App\Repositories\BlogRepository;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

class RepositoriesProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BlogRepository::class, function ($app) {
            return new BlogRepository($app->make('request'));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        
    }

    public function provides()
    {
        return [
            BlogRepository::class
        ];
    }
}
