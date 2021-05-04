<?php

namespace App\Http\Middleware;

use Closure;

class LanguageConfigurator
{

    public function handle($request, Closure $next)
    {
        if (Auth()->user()) {
            app()->setLocale(Auth()->user()->language);
        }

        return $next($request);
    }

}
