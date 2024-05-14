<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ChangeLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */


        public function handle($request, Closure $next)
    {
        // Set the locale from session or default to 'ar'
        app()->setLocale(session('lang', 'ar'));

        return $next($request);

    }
}
