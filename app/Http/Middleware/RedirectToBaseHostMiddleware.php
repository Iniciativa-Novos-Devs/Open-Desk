<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectToBaseHostMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(config('app.redirect_to_base_host', false))
        {
            $base_host  = config('app.base_host');
            $app_url    = config('app.url');
            $host       = $request->getHost();

            if($base_host !== $host)
                return redirect($app_url);
        }

        return $next($request);
    }
}
