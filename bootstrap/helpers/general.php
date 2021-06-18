<?php


use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

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
        if (auth_group_id()) {
            $group_id = auth_group_id();
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
        if (isset($permissions[$key]) and $permissions[$key] == 'true'){
            return true;
        }
        else{
            return false;
        }
    }
}
if (!function_exists('bank_action_types')){
    function bank_action_types() {
        $type_options = [
            ['id' => 'pub_site', 'text' => __('adnetwork.sites'), 'selected' => 1],
//            ['id' => 'user', 'text' => __('adnetwork.salary'), 'selected' => 0],
            ['id' => 'ad_agency_finance', 'text' => __('adnetwork.agencies'), 'selected' => 0],
            ['id' => 'pub_wallet', 'text' => __('adnetwork.pub_wallet'), 'selected' => 0],
            ['id' => 'finance_cost', 'text' => __('adnetwork.finance_cost'), 'selected' => 0],
        ];
        return $type_options;
    }
}



if (!function_exists('status_options')){
    function status_options() {
        $status_options = [
            ['id' => "", 'text' => __('adnetwork.all'), 'selected' => 1],
            ['id' => "11", 'text' => __('adnetwork.ad_static_status_11'), 'selected' => 0],
            ['id' => "12", 'text' => __('adnetwork.ad_static_status_12'), 'selected' => 0],
            ['id' => "17", 'text' => __('adnetwork.ad_static_status_17'), 'selected' => 0],
            ['id' => "10", 'text' => __('adnetwork.ad_static_status_10'), 'selected' => 0],
            ['id' => "27", 'text' => __('adnetwork.ad_static_status_27'), 'selected' => 0],
            ['id' => "40", 'text' => __('adnetwork.ad_static_status_40'), 'selected' => 0],

        ];
        return $status_options;
    }
}


if (!function_exists('user_login_type')){
    function user_login_type($type){
        $login_type = Session::get('user_login_type');
        if (!$login_type) {
            $login_type = 'advertiser';
            Session::put('user_login_type', $login_type);
        }
        if ($login_type == $type)
            return true;
        else
            return false;

    }
}

if (!function_exists('get_dimension')){
    function get_dimension($id){
        if($id == '3')
            return '728x90';
        elseif($id == '5')
            return '320x100';
        elseif($id == '6')
            return '300x600';
        elseif($id == '7')
            return '300x250';
        elseif($id == '12')
            return '468x60';
        elseif($id == '16')
            return '240x400';
        elseif($id == '17')
            return '160x600';
        elseif($id == '30')
            return __('adnetwork.ad_static_dimension_name_30');
        else
            return $id;
    }
}
if (!function_exists('get_format_type')){
    function get_format_type($id){
        if($id == '0')
            return __('adnetwork.all');
        elseif($id == '261')
            return __('adnetwork.ad_static_name_261');
        else
            return $id;
    }
}


if (!function_exists('auth_id')){
    function auth_id(){
        $auth = Session::get('auth_id');
        if (!$auth) {
            $user = auth()->user();
            $auth = $user->id;
            Session::put('auth_id', $auth);
        }
        return $auth;
    }
}
if (!function_exists('auth_group_id')){
    function auth_group_id(){
        $auth = Session::get('auth_group_id');
        if (!$auth) {
            $user = auth()->user();
            $auth = $user->user_group_id;
            Session::put('auth_group_id', $auth);
        }
        return $auth;
    }
}
