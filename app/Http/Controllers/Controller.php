<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;



class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $api;
    protected $auth;

    public  function __construct()
    {
        global $auth;
        //Load All Helper Files without using composers
        Statics\Helper::Load();
        $this->api = api();
        $this->auth = remote_auth();
        //View Global Variables


        view()->share([
            "auth"   => $this->auth,
            "user"	 => (object) auth()->user(),
        ]);
    }

}
