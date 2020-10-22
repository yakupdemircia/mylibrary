<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->all();
    }

    public function register()
    {
        //
    }

    public function all()
    {
        view()->composer('frontend.*', function ($view) {
            $user = Auth::user();
            $view->with('user', $user);
        });
    }
}
