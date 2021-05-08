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
        $item = auth()->user();
        if ($request->isMethod('post')){
            $opt = [
                "user_id" => auth()->id(),
                'email' => $request->email,
                'amount' => $request->amount,
                'phone' => $request->phone,
                'action_id' => $request->action_id,
                'cart_type' => $request->cardType,
                'bank_type' => $request->bankType,
                'description' => 'increase'
            ];
//            $result = $this->api->increase_wallet($opt)->post();
//            dd($result);
            dd($opt);
            dd($request->all());
        }
        return view('auth.profile.wallet.increase', compact('item'));
    }


    public function history(Request $request, $lang)
    {
        return view('auth.profile.wallet.history');
    }
}
