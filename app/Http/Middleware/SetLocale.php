<?php

namespace App\Http\Middleware;

use Closure;
use Jenssegers\Date\Date;
use Illuminate\Support\Facades\Cache;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  String  $locale
     * @return mixed
     */

    public function handle($request, Closure $next, $locale = null)
    {

        //debug mode switcher
        $debugKey = env('APP_DEBUG_KEY');

        if (request()->has('debug') && request()->get('debug') == $debugKey) {
            session()->put('debug_mode_on', true);
        }

        if (session()->has('debug_mode_on')) {
            config()->set('app.debug', true);
        }

        if ($locale) {
            app()->setLocale($locale);
            Date::setLocale($locale);
        }

        //Cache::setPrefix('web:' . app()->getLocale());
        return $next($request);
    }

}
