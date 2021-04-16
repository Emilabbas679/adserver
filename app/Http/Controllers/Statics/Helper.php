<?php

namespace App\Http\Controllers\Statics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Helper extends Controller
{

    public static function Load(){
        $helperDir =  base_path() . '/bootstrap/helpers';
        if ($dh = opendir($helperDir)){
            while($file = readdir($dh)){
                if (is_file($helperDir . '/' . $file)){
                    require $helperDir . '/' . $file;
                }
            }
        }
    }
}
