<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

class Language
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
        $lang = $request->route('lang');
        if (!$lang)
            $lang = $request->route()->uri();
        $langs = ['az', 'en', 'ru','tr'];
        if (in_array($lang, $langs)) {
            if ($lang != app()->getLocale()) {
                Session::put(['locale' => $lang]);
                App::setLocale(Session::get('locale'));
            }
            return $next($request);
        }
        abort(404);
    }
}
