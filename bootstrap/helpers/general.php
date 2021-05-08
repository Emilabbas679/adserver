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


if (!function_exists('permission_include')){
    function permission_include()
    {
        if (auth()->user()->user_group_id) {
            $group_id = auth()->user()->user_group_id;
            $file = base_path("resources/permissions/groups/$group_id.php");
            if (!is_file($file)) {
                $api = new \App\Http\Controllers\API();
                $data = $api->get_user_group_params(['user_group_id' => $group_id])->post();
                $data = $data['data'];
                $ftemplate = "<?php".' $permissions = [';
                file_put_contents($file, $ftemplate);
                $current = file_get_contents($file);
                foreach ($data as $k=>$v) {
                    if ($v == true) $v = 'true'; else $v='false';
                    $current = $current."\n".'"'.$k.'" => "'.$v.'",'."\n";
                }
                $current = $current."\n ]; ";
                file_put_contents($file, $current);
            }
            include($file);
            return $permissions;
        }
        else
            return [];

    }
}


if (!function_exists('check_permission')){
    function check_permission($key, $permissions) {
        return true;
        if (isset($permissions[$key]) and $permissions[$key] == 'true'){
            return true;
        }
        else{
            return false;
        }
    }
}
