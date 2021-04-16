@extends('layouts.auth')
@section('title', __('titles.advertiser_title'))
@section('header')
<script src="https://www.google.com/recaptcha/api.js?render=6LfpZoEaAAAAAAvddE93YljQ1NmtqpmqtFiG8Ezl"></script>
<script>
    grecaptcha.ready(function () {
        grecaptcha.execute('6LfpZoEaAAAAAAvddE93YljQ1NmtqpmqtFiG8Ezl', { action: 'contact' }).then(function (token) {
            var recaptchaResponse = document.getElementById('recaptchaResponse');
            recaptchaResponse.value = token;
        });
    });
</script>
<style>
    #g-recaptcha-response {
        display: block !important;
        position: absolute;
        margin: -78px 0 0 0 !important;
        width: 302px !important;
        height: 76px !important;
        z-index: -999999;
        opacity: 0;
    }
    .grecaptcha-badge{
        display: none;
    }
</style>
@endsection
@section('content')
<div class="reg">
    <div class="ct-a">
        <div class="ct-b">
            <!-- Login panel start -->
            <section class="login-panel">
                <div class="login-panel-wrap">
                    <div class="lp-top">
                        <div class="logo">
                            <a href="{{route('login', app()->getLocale())}}"></a>
                        </div>
                        <div class="return">
                            <a href="https://smartbee.az"><span>{{__('auth.return_home')}}</span></a>
                        </div>
                    </div>
                    <div class="lp-content">
                        <div class="lp-col">
                            <div class="lp-left">
                                <div class="lp-symb symb-1 w-1"></div>
                                <div class="lp-a">{{__('auth.welcome')}}</div>
                                <div class="lp-b">
                                  {{__('auth.advertiser_welcome')}}
                                </div>
                            </div>
                        </div>
                        <div class="lp-col">
                            <div class="lp-right">
                                <h2 class="lp-a">{{__('auth.advertiser_title')}}</h2>
                                <div class="lp-b">{{__('auth.smartbee_platform')}}</div>
                                <div class="lp-form">
                                    <form method="post" action="{{route('advertiser_login', app()->getLocale())}}">
                                        @csrf
                                        @include('flash-message')

                                        <div class="lp-input mail">
                                            <input  class="@error('email') input-error @enderror" type="text" placeholder="{{__('placeholders.user_email')}}" id="username" name="email" value="{{old('email')}}">
                                        </div>
                                        @error('email')
                                        <div class="notification-error">{{ $message }}</div>
                                        @enderror

                                        <div class="lp-input pass">
                                            <input id="pass"  class="@error('password') input-error @enderror" type="password" placeholder="{{__('placeholders.user_password')}}" id="password" name="password" >
                                            <div class="show-pass" onclick="myFunction()"></div>
                                        </div>
                                        @error('password')
                                        <div class="notification-error">{{ $message }}</div>
                                        @enderror

                                        <div class="inp-bottom">
                                            <div class="lp-check">
                                                <input id="check" type="checkbox" name="remember_me">
                                                <label for="check">{{__('auth.remember_me')}}</label>

                                            </div>
                                            <div class="forget">
                                                <a href="{{route('advertiser_password', app()->getLocale())}}">{{__('auth.reset_pass')}}</a>
                                            </div>
                                        </div>
                                        <input type="hidden" name="recaptcha_response" id="recaptchaResponse">


                                        <div class="lp-button">
                                            <button type="submit">{{__('auth.login')}}</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="lp-bt">
                                    <div class="lp-block">
                                        <div class="lp-l">{{__('auth.hesabn_yoxdur')}}</div>
                                        <div class="lp-r"><a href="{{route('advertiser_register', app()->getLocale())}}">{{__('auth.register')}}</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Login panel end -->
        </div>
    </div>
</div>
@endsection
@section('js')
<script>

    function myFunction() {
        var x = document.getElementById("pass");
        var z = document.getElementsByClassName("show-pass")[0]
        if (x.type === "password") {
            x.type = "text";
            z.classList.add("showed");
        }
        else{

            x.type = "password";
            z.classList.remove("showed");
        }
    }


</script>
@endsection
