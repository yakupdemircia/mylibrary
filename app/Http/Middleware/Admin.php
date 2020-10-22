<?php

namespace App\Http\Middleware;

use Closure;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     * @param String                   $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'admin')
    {

        if (!auth()->guard($guard)->guest()) {
            return $next($request);
        } else {
            return redirect('/panel/login');
        }

    }
}
