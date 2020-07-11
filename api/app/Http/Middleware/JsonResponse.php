<?php

namespace App\Http\Middleware;

use Closure;

/**
 * Class ForceJsonResponse
 * @package App\Http\Middleware
 *
 * @see https://medium.com/@martin.riedweg/laravel-5-7-api-authentification-with-laravel-passport-92b909e12528
 */
class JsonResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->is('api/*')) {
            $request->headers->set('Accept', 'application/json');
        }

        return $next($request);
    }
}
