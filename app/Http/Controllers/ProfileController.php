<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->api = new API();
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login', app()->getLocale());
    }


    public function settings(Request $request)
    {
        if ($request->isMethod('post')) {
            $user = \auth()->user();
            $opt = [
                'phone' => (integer) $request->phone,
                'user_id'=>$user->id,
                'language_id' => $request->language_id,
                'full_name' => $request->full_name,
                'user_name' => $request->user_name,
                'gender' => $request->gender,
                'currency_id' => $request->currency_id,
                'user_group_id' => $request->user_group_id

            ];

            if ($request->new_password != null) {
                if ($request->new_password != $request->confirm_new_password)
                    return redirect()->back()->with('error', __('adnetwork.passwords_doesnot_match'));
                else {
                    $opt['password'] = $request->new_password;
                    $user->password = Hash::make($request->new_password);
                }
            }
            $usr_update = $this->api->update_user($opt)->post();
            if ($usr_update['status'] == 'failed')
                return redirect()->back()->with('error', __('adnetwork.unexpected_error'));
            $user->name = $request->full_name;
            $user->phone = $request->phone;
            $user->save();
            return redirect()->route('profile_settings', app()->getLocale())->with('success', __('adnetwork.succesfull_updated'));

        }
        $user = $this->api->get_user(['user_id' => \auth()->id()])->post();
        $item = $user['data'][0];
        $lang_data = $this->api->get_langauage()->post();
        $langs = $lang_data['data'];
        $lang_options = [];
        foreach ($langs as $lang){
            $selected = 0;
            if ($item['language_id'] == $lang['language_id'])
                $selected = 1;
            $lang_options[] = ['id' => $lang['language_id'], 'text' => $lang['title'], 'selected' => $selected];
        }

        $form = [];
        $form[] = ['type' => "input:readonly", 'id'=>'user_name', 'value'=>$item['user_name'], 'title' => __('adnetwork.username')];
        $form[] = ['type' => "input:readonly", 'id'=>'email', 'value'=>$item['email'], 'title' => __('adnetwork.email')];
        $form[] = ['type' => "input:text", 'id'=>'full_name', 'value'=>$item['full_name'], 'title' => __('adnetwork.full_name')];
        $form[] = ['type' => "input:text", 'id'=>'phone', 'value'=>$item['phone'], 'title' => __('adnetwork.phone_number')];
        $form[] = ['type' => 'select', 'id'=>'language_id', 'title' => __('adnetwork.language'), 'options' => $lang_options, 'placeholder' => __('adnetwork.language_placeholder')];
        $form[] = ['type' => "input:readonly", 'id'=>'password', 'value'=>'*********', 'title' => __('adnetwork.current_password')];
        $form[] = ['type' => "input:password", 'id'=>'new_password', 'value'=>'', 'title' => __('adnetwork.new_password')];
        $form[] = ['type' => "input:password", 'id'=>'confirm_new_password', 'value'=>'', 'title' => __('adnetwork.confirm_new_password')];
        $form[] = ['type' => "input:hidden", 'id'=>'gender', 'value'=>$item['gender']];
        $form[] = ['type' => "input:hidden", 'id'=>'user_group_id', 'value'=>$item['user_group_id']];
        $form[] = ['type' => "input:hidden", 'id'=>'currency_id', 'value'=>$item['currency_id']];

        return view('auth.profile.settings', compact('item','form'));

    }


    public function viewModeExit(Request $request)
    {
        Session::put("auth_id", auth()->id());
        Session::put("auth_group_id", auth()->user()->user_group_id);
        return redirect()->route('home');
    }
}
