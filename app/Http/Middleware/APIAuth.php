<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Controllers\API;
use App\Http\Middleware\APIAuth as AAuth;

class APIAuth
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
        global $api, $auth;
		$api = new API;
		$auth = new AAuth;
        \App\Http\Controllers\Statics\Helper::Load();

        return $next($request);
    }
}
