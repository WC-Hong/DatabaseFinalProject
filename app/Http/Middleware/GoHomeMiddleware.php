<?php

namespace App\Http\Middleware;

use Closure;

class GoHomeMiddleware
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
        if (!$request->session()->has('account_id'))
            return redirect('/');
        else
            return $next($request);
    }
}
