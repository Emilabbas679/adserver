<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserPermission
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
        if (isset($permissions['user.can_manage_all_users']) and $permissions['user.can_manage_all_users'] == 'true')
            return $next($request);
        else
            return redirect('/');
    }
}
