@extends('layouts.auth')
@section('title', __('titles.advertiser_register'))
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
                            <a href="{{route('advertiser_login', app()->getLocale())}}"></a>
                        </div>
                        <div class="return">
                            <a href="https://smartbee.az"><span>{{__('auth.return_home')}}</span></a>
                        </div>
                    </div>
                    <div class="lp-content">
                        <div class="lp-col">
                            <div class="lp-left">
                                <div class="lp-symb symb-2 w-2"></div>
                                <div class="lp-a">{{__('auth.advertiser_title')}}</div>
                                <div class="lp-b">
                                    {{__('auth.advertiser_welcome')}}
                                </div>
                            </div>
                        </div>
                        <div class="lp-col">
                            <div class="lp-right for-reg">
                                <h2 class="lp-a">{{__('auth.register')}}</h2>
                                <div class="lp-b">{{__('auth.smartbee_platform')}}</div>
                                <div class="lp-form">

                                    <form action="{{route('advertiser_register', app()->getLocale())}}" METHOD="POST" id="register-form">
                                        @csrf
                                        @include('flash-message')


                                        <div class="lp-input mail">
                                            <input id="email" class="@error('email') input-error @enderror" type="text" placeholder="{{__('placeholders.user_email')}}" name="email" value="{{old('email')}}">
                                        </div>
                                        @error('email')
                                        <div class="notification-error">{{ $message }}</div>
                                        @enderror


                                        <div class="lp-input phone-register">
                                            <input id="phone-register"  class="@error('phone-register') input-error @enderror"  type="text" name="phone-register">
                                        </div>
                                        @error('phone-register')
                                        <div class="notification-error">{{ $message }}</div>
                                        @enderror

                                        <input type="hidden" name="phone" id="phone">

                                        <div class="lp-input pass">
                                            <input id="pass" type="password"  class="@error('password') input-error @enderror"  placeholder="{{__('placeholders.user_password')}}" name="password" value="{{old('password')}}">
                                            <div class="show-pass" onclick="showp()"></div>
                                        </div>
                                        @error('password')
                                        <div class="notification-error">{{ $message }}</div>
                                        @enderror

                                        <input type="hidden" name="recaptcha_response" id="recaptchaResponse">

                                        <div class="lp-button">
                                            <button type="submit" id="rgst">{{__('auth.register')}}</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="lp-bt">
                                    <div class="lp-block">
                                        <div class="lp-l">{{__('auth.hesabin_var')}}</div>
                                        <div class="lp-r"><a href="{{route('advertiser_login', app()->getLocale())}}">{{__('auth.login')}}</a></div>
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
    function showp() {
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
<script src="/js/jquery.js"></script>

<script src="/js/intlmin.js?v=1"></script>
<script src="/js/utils.js?v=1"></script>


<script>
    $(document).ready(function(){
        $("#phone-register").intlTelInput({
            preferredCountries: [ "az", "gb" ],
        });
        $("#rgst").click(function (){
            var intlNumber = $("#phone-register").intlTelInput("getNumber"); // get full number eg +17024181234
            $("#phone").val(intlNumber)
        });
    });
</script>


@endsection
