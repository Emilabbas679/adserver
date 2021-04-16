<?php


use Illuminate\Support\Facades\Cache;

if (!function_exists('api')) {
    function api()
    {
        global $api;
        return $api;
    }
}


if (!function_exists('apiauth')) {
    function apiauth(){
        global $auth;
        return $auth;
    }
}
if (!function_exists('remote_auth')) {
    function remote_auth()
    {
        global $auth;
        return $auth;
    }
}


if (!function_exists("selected_exist")){
    function selected_exist($request, $key , $check)
    {
        if ($request->has($key) and $request->$key == $check)
            return 'selected';
        else
            return '';
    }
}


if (!function_exists('selected'))
{
    function selected($a,$b){
        if ($a == $b)
            return 'selected';
        return '';
    }
}

if (!function_exists('impression_stats')){
    function impression_stats($id)
    {
        $items = Cache::remember('impression_stats_'.$id, now()->addMinutes(10), function () use ($id) {
            $api = new \App\Http\Controllers\API();
            $data = $api->click_impression_stats(['user_id' => $id, 'stats_type' => "ad_dashboard"])->post();
            return $data['data'];
        });
        return $items;
    }
}
