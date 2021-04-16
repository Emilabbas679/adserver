<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
class Localization
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
        if(Session::get('locale')) {
            $lang = Session::get('locale');
            App::setLocale($lang);
        }
        else
        {
            if( isset($_SERVER['HTTP_CF_IPCOUNTRY']) )
            {
                $setLocale = strtolower($_SERVER['HTTP_CF_IPCOUNTRY']);
                if( ! in_array($setLocale, ['az'] ) )
                    App::setLocale('ru');
                else
                    App::setLocale('az');
            }
            else
            {
                App::setLocale('az');
            }
        }
        return $next($request);
    }
}
