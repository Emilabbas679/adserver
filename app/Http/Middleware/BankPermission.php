<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BankPermission
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
        $group_id = auth()->user()->user_group_id;
        include(base_path("resources/permissions/groups/$group_id.php"));
        if (isset($permissions['adnetwork.can_manage_accounting']) and $permissions['adnetwork.can_manage_accounting'] == 'true')
            return $next($request);
        else
            return redirect('/');
    }
}
