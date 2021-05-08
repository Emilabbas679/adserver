@extends('layouts.auth')
@section('title', __('adnetwork.advertiser_login_sub_title'))
@section('title', '')
@section('content')
    <div class="reg">
        <div class="ct-a">
            <div class="ct-b">
                <!-- Login panel start -->
                <section class="login-panel">
                    <div class="login-panel-wrap">
                        <div class="lp-top">
                            <div class="logo">
                                <a href="#"></a>
                            </div>
                            <div class="return">
                                <a href="{{route('home')}}"><span>{{__('adnetwork.ana_s_hif_y_qay_t')}}</span></a>
                            </div>
                        </div>
                        <div class="lp-content">
                            <div class="ap-top">
                                <div class="ap-text">{{__('adnetwork.welcome')}}</div>
                                <div class="ap-symb"></div>
                            </div>
                            <div class="lp-col">
                                <div class="ap-left">
                                    <h2 class="z-text">{{__('adnetwork.advertiser_title')}}</h2>
                                    <div class="z-button">
                                        <a href="{{route('advertiser_login', app()->getLocale())}}">{{__('adnetwork.login')}}</a>
                                    </div>
                                    <div class="lp-bt">
                                        <div class="lp-block">
                                            <div class="lp-l">{{__('adnetwork.hesab_n_yoxdur')}}</div>
                                            <div class="lp-r"><a href="{{route('advertiser_register', app()->getLocale())}}">{{__('adnetwork.register')}}</a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="lp-col">
                                <div class="ap-right">
                                    <h2 class="z-text">{{__('adnetwork.publisher_title')}}</h2>
                                    <div class="z-button">
                                        <a href="{{route('publisher_login', app()->getLocale())}}">{{__('adnetwork.login')}}</a>
                                    </div>
                                    <div class="lp-bt">
                                        <div class="lp-block">
                                            <div class="lp-l">{{__('adnetwork.hesab_n_yoxdur')}}</div>
                                            <div class="lp-r"><a href="{{route('publisher_register', app()->getLocale())}}">{{__('adnetwork.register')}}</a></div>
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
