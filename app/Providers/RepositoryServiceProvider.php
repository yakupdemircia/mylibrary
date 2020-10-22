<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Http\Repositories\AdminRepositoryInterface',
            'App\Http\Repositories\AdminRepository'
        );

        $this->app->bind(
            'App\Http\Repositories\UserRepositoryInterface',
            'App\Http\Repositories\UserRepository'
        );

        $this->app->bind(
            'App\Http\Repositories\CategoryRepositoryInterface',
            'App\Http\Repositories\CategoryRepository'
        );

        $this->app->bind(
            'App\Http\Repositories\PublisherRepositoryInterface',
            'App\Http\Repositories\PublisherRepository'
        );

        $this->app->bind(
            'App\Http\Repositories\AuthorRepositoryInterface',
            'App\Http\Repositories\AuthorRepository'
        );

        $this->app->bind(
            'App\Http\Repositories\BookRepositoryInterface',
            'App\Http\Repositories\BookRepository'
        );

        $this->app->bind(
            'App\Http\Repositories\IssueRepositoryInterface',
            'App\Http\Repositories\IssueRepository'
        );


    }
}
