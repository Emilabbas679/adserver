<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class WalletController extends Controller
{
    public function __construct()
    {
        $this->api = new API();
    }


    public function increase(Request $request, $lang)
    {

        if ($request->isMethod('post')){

        }
        return view('auth.profile.wallet.increase');
    }


    public function history(Request $request, $lang)
    {
        return view('auth.profile.wallet.history');
    }
}