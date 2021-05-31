<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Testing\Fluent\Concerns\Has;

class UserController extends Controller
{


    public function __construct(Request $request)
    {
        $this->middleware('guest');
        $this->api = new API();
    }

    public function login()
    {
        return view('auth.login');
    }


    public function advertiserLogin(Request $request)
    {
        if(request()->isMethod('post')) {
            $request->validate([
                'email' => ['required', 'string', 'min:5', 'max:100'],
                'password' => ['required', 'string', 'min:8', 'max:100'],
            ],
                [
                    'email.required' => __('adnetwork.email_is_required'),
                    'email.min' => __('adnetwork.email_must_be_min_5'),
                    'email.max' => __('adnetwork.email_must_be_max_100'),
                    'password.required' => __('adnetwork.password_is_required'),
                    'password.min' => __('adnetwork.password_must_be_min_5'),
                    'password.max' => __('adnetwork.password_must_be_max_100'),
                ]
            );

            if ($this->recaptcha_verify($request->recaptcha_response) == false)
                return redirect()->route('advertiser_login', app()->getLocale())->with('error','adnetwork.capthca_error');


            $opt = [
                'login' => $request->email,
                'password' => $request->password,
                'remember_me' => false
            ];
            if (isset($request->remember_me))
                $opt['remember_me'] = true;
            $login_data = $this->api->user_login($opt)->post();
            if (isset($login_data['status']) and $login_data['status'] == 'failed')
                return redirect()->route('advertiser_login', app()->getLocale())->with(['error'=>__('adnetwork.username_not_exist_or_pass_not_match')]);
            $data = $login_data['data'];
            $user = User::find($data['user_id']);
            if ($user){
                $user->last_login = Carbon::now();
                $user->save();
            }
            else{
                User::insert([
                    'created_at' => Carbon::now(),
                    'last_login' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'name' => $data['full_name'],
                    'email' => $data['email'],
                    'gender' => $data['gender'],
                    'id' => $data['user_id'],
                    'user_group_id' => $data['user_group_id'],
                    'phone' => $data['phone'],
                    'password' => Hash::make($request->password)
                ]);
            }
            $user = User::find($data['user_id']);
            $user->update(['user_group_id' => $data['user_group_id']]);
            Auth::Login($user);
            Session::put('user_login_type', 'advertiser');

            return redirect('/');
        }
        else
            return view('auth.advertiser.login');
    }


    public function publisherLogin(Request $request)
    {
        if(request()->isMethod('post')) {
            $request->validate([
                'email' => ['required', 'string', 'min:5', 'max:100'],
                'password' => ['required', 'string', 'min:8', 'max:100'],
            ],
                [
                    'email.required' => __('adnetwork.email_is_required'),
                    'email.min' => __('adnetwork.email_must_be_min_5'),
                    'email.max' => __('adnetwork.email_must_be_max_100'),
                    'password.required' => __('adnetwork.password_is_required'),
                    'password.min' => __('adnetwork.password_must_be_min_5'),
                    'password.max' => __('adnetwork.password_must_be_max_100'),
                ]
            );
            if ($this->recaptcha_verify($request->recaptcha_response) == false)
                return redirect()->route('publisher_login', app()->getLocale())->with('error','adnetwork.capthca_error');
            $opt = [
                'login' => $request->email,
                'password' => $request->password,
                'remember_me' => false
            ];
            if (isset($request->remember_me))
                $opt['remember_me'] = true;
            $login_data = $this->api->user_login($opt)->post();
            if (isset($login_data['status']) and $login_data['status'] == 'failed')
                return redirect()->route('publisher_login', app()->getLocale())->with(['error'=>__('adnetwork.username_not_exist_or_pass_not_match')]);
            $data = $login_data['data'];
            $user = User::find($data['user_id']);
            if ($user){
                $user->last_login = Carbon::now();
                $user->save();
            }
            else{
                User::insert([
                    'created_at' => Carbon::now(),
                    'last_login' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'name' => $data['full_name'],
                    'email' => $data['email'],
                    'user_group_id' => $data['user_group_id'],
                    'gender' => $data['gender'],
                    'id' => $data['user_id'],
                    'phone' => $data['phone']
                ]);
                $user = User::find($data['user_id']);
            }

            Auth::login($user, $opt['remember_me']);
            $user->update(['user_group_id' => $data['user_group_id']]);

            Session::put('user_login_type', 'publisher');

            return redirect()->route('home');
        }
        else
            return view('auth.publisher.login');
    }


    public function publisherRegister(Request $request)
    {
        if ($request->isMethod('post')){
            $request->validate([
                'email' => ['required', 'string', 'min:5', 'max:100'],
                'password' => ['required', 'string', 'min:8', 'max:100'],
                'phone-register' => ['required', 'string', 'min:8', 'max:100'],
            ],
                [
                    'email.required' => __('adnetwork.email_is_required'),
                    'phone-register.required' => __('adnetwork.phone_is_required'),
                    'email.min' => __('adnetwork.email_must_be_min_5'),
                    'email.max' => __('adnetwork.email_must_be_max_100'),
                    'password.required' => __('adnetwork.password_is_required'),
                    'password.min' => __('adnetwork.password_must_be_min_5'),
                    'password.max' => __('adnetwork.password_must_be_max_100'),
                ]
            );
            if ($this->recaptcha_verify($request->recaptcha_response) == false)
                return redirect()->route('publisher_login', app()->getLocale())->with('error','adnetwork.capthca_error');
            $user_check = $this->api->get_user(['email'=>$request->email])->post();
            if (isset($user_check['status']) and $user_check['status'] == 'success')
                return redirect()->route('publisher_register', app()->getLocale())->with(['error'=>__('adnetwork.user_exist')]);
            $phone = ltrim( $request->phone, '+');
            $result = $this->api->create_user([
                "user_name" => $request->email,
                "full_name" => $request->email,
                "email" => $request->email,
                'phone' => $phone,
                "user_group_id"=>2,
                "language_id" => "AZ",
                "currency_id"=> "AZN",
                'password' => $request->get('password'),
                'gender' => 0,
            ])->post();
            if (isset($result['status']) and $result['status'] == 'success') {
                $data = $result['data'];
                User::insert([
                    'last_login' => Carbon::now(),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'password' => Hash::make($request->password),
                    'name' => $request->email,
                    'email' => $request->email,
                    'phone' => $phone,
                    'id' =>  $data['user_id'],
                    'user_group_id' =>  $data['user_group_id']
                ]);
                $user = User::find($data['user_id']);
                Auth::login($user, true);
                Session::put('user_login_type', 'publisher');
                return redirect('/'.app()->getLocale());
            }
            return redirect()->route('publisher_register', app()->getLocale())->with('error', __('adnetwork.something_went_wrong'));
        }
        return view('auth.publisher.register');
    }


    public function advertiserRegister(Request $request)
    {
        if ($request->isMethod('post')){
            $request->validate([
                'email' => ['required', 'string', 'min:5', 'max:100'],
                'password' => ['required', 'string', 'min:8', 'max:100'],
                'phone-register' => ['required', 'string', 'min:8', 'max:100'],
            ],
                [
                    'email.required' => __('adnetwork.email_is_required'),
                    'phone-register.required' => __('adnetwork.phone_is_required'),
                    'email.min' => __('adnetwork.email_must_be_min_5'),
                    'email.max' => __('adnetwork.email_must_be_max_100'),
                    'password.required' => __('adnetwork.password_is_required'),
                    'password.min' => __('adnetwork.password_must_be_min_5'),
                    'password.max' => __('adnetwork.password_must_be_max_100'),
                ]
            );
            if ($this->recaptcha_verify($request->recaptcha_response) == false)
                return redirect()->route('advertiser_login', app()->getLocale())->with('error','adnetwork.capthca_error');
            $user_check = $this->api->get_user(['email'=>$request->email])->post();
            if (isset($user_check['status']) and $user_check['status'] == 'success')
                return redirect()->route('advertiser_register', app()->getLocale())->with(['error'=>__('adnetwork.user_exist')]);
            $phone = ltrim( $request->phone, '+');
            $result = $this->api->create_user([
                "user_name" => $request->email,
                "full_name" => $request->email,
                "email" => $request->email,
                'phone' => $phone,
                "user_group_id"=>2,
                "language_id" => "AZ",
                "currency_id"=> "AZN",
                'password' => $request->get('password'),
                'gender' => 0,
            ])->post();
            if (isset($result['status']) and $result['status'] == 'success') {
                $data = $result['data'];
                User::insert([
                    'last_login' => Carbon::now(),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'password' => Hash::make($request->password),
                    'name' => $request->email,
                    'email' => $request->email,
                    'phone' => $phone,
                    'id' =>  $data['user_id'],
                    'user_group_id' =>  $data['user_group_id']
                ]);
                $user = User::find($data['user_id']);
                Auth::login($user, true);
                Session::put('user_login_type', 'advertiser');
                return redirect('/'.app()->getLocale());
            }
            return redirect()->route('advertiser_register', app()->getLocale())->with('error', __('adnetwork.something_went_wrong'));
        }
        return view('auth.advertiser.register');
    }


    public function advertiserPassword(Request $request)
    {
        if ($request->isMethod('post')){
            $request->validate([
                'email' => ['required', 'string', 'min:5', 'max:100'],
            ],
                [
                    'email.required' => __('adnetwork.email_is_required'),
                ]
            );
            if ($this->recaptcha_verify($request->recaptcha_response) == false)
                return redirect()->route('advertiser_login', app()->getLocale())->with('error','adnetwork.capthca_error');

            $user_check = $this->api->get_user(['email'=>$request->email])->post();
            if (!isset($user_check['status']) or (isset($user_check['status']) and $user_check['status'] == 'failed'))
                return redirect()->route('advertiser_password', app()->getLocale())->with(['error'=>__('adnetwork.user_does_not_exist')]);

            $opt = [
                'email' => $request->email,
                'site_title' => env('APP_NAME'),
                'verify_link'=>env("APP_URL")."/".app()->getLocale()."/advertiser/user/forgot/password/{hash_code}",
            ];
            $data = $this->api->user_new_password($opt)->post();
            if (isset($data['status']) and $data['status'] == 'success')
                return redirect()->route('advertiser_login', app()->getLocale())->with('success', __('notificaiton.email_has_sent'));
            return redirect()->route('advertiser_password', app()->getLocale())->with('error', __('adnetwork.something_went_wrong'));

        }
        return view('auth.advertiser.password');
    }


    public function publisherPassword(Request $request)
    {
        if ($request->isMethod('post')){
            $request->validate([
                'email' => ['required', 'string', 'min:5', 'max:100'],
            ],
                [
                    'email.required' => __('adnetwork.email_is_required'),
                ]
            );
            if ($this->recaptcha_verify($request->recaptcha_response) == false)
                return redirect()->route('publisher_login', app()->getLocale())->with('error','adnetwork.capthca_error');

            $user_check = $this->api->get_user(['email'=>$request->email])->post();
            if (!isset($user_check['status']) or (isset($user_check['status']) and $user_check['status'] == 'failed'))
                return redirect()->route('publisher_password', app()->getLocale())->with(['error'=>__('adnetwork.user_does_not_exist')]);

            $opt = [
                'email' => $request->email,
                'site_title' => env('APP_NAME'),
                'verify_link'=>env("APP_URL")."/".app()->getLocale()."/publisher/user/forgot/password/{hash_code}",
            ];
            $data = $this->api->user_new_password($opt)->post();
            if (isset($data['status']) and $data['status'] == 'success')
                return redirect()->route('publisher_login', app()->getLocale())->with('success', __('notificaiton.email_has_sent'));
            return redirect()->route('publisher_password', app()->getLocale())->with('error', __('adnetwork.something_went_wrong'));

        }
        return view('auth.publisher.password');
    }


    public function publisherPasswordVerify($lang, $hash)
    {
        $opt = [
            'hash_code'=>$hash,
            'site_title' => env('APP_NAME'),
            'verify_link'=>route('publisher_login', app()->getLocale()),
        ];
        $result = $this->api->user_verify_password($opt)->post();
        if (isset($result['status']) and $result['status'] == 'success') {
            $data = $result['data'];
            User::where('id', $data['user_id'])->update(['password'=> Hash::make($data['password'])]);
            return redirect()->route('publisher_login', app()->getLocale())->with('success', __('adnetwork.new_pass_has_sent_to_mail'));
        }
        else
            return redirect()->route('publisher_password', app()->getLocale())->with('error', __('adnetwork.url_expired'));

    }


    public function advertiserPasswordVerify($lang,$hash)
    {
        $opt = [
            'hash_code'=>$hash,
            'site_title' => env('APP_NAME'),
            'verify_link'=>route('advertiser_login', app()->getLocale()),
        ];
        $result = $this->api->user_verify_password($opt)->post();
        if (isset($result['status']) and $result['status'] == 'success') {
            $data = $result['data'];
            User::where('id', $data['user_id'])->update(['password'=> Hash::make($data['password'])]);
            return redirect()->route('advertiser_login', app()->getLocale())->with('success', __('adnetwork.new_pass_has_sent_to_mail'));
        }
        else
            return redirect()->route('advertiser_password', app()->getLocale())->with('error', __('adnetwork.url_expired'));
    }


    public function recaptcha_verify( $recaptcha_response )
    {
        $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
        $recaptcha_secret = "6LfpZoEaAAAAAKoz0bnOhY4aO3i4DOG24a-HlYvv";
        $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
        $recaptcha = json_decode($recaptcha);

        if ($recaptcha->success==true && isset($recaptcha->score) && $recaptcha->score >= 0.5)
        {
            return true;
        }

        return false;
    }
}
