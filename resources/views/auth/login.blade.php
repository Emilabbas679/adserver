@extends('layouts.auth')
@section('title', __('titles.login'))
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
                                <a href="https://smartbee.az/"><span>{{__('auth.return_home')}}</span></a>
                            </div>
                        </div>
                        <div class="lp-content">
                            <div class="ap-top">
                                <div class="ap-text">{{__('auth.welcome')}}</div>
                                <div class="ap-symb"></div>
                            </div>
                            <div class="lp-col">
                                <div class="ap-left">
                                    <h2 class="z-text">{{__('auth.advertiser_title')}}</h2>
                                    <div class="z-button">
                                        <a href="{{route('advertiser_login', app()->getLocale())}}">{{__('auth.login')}}</a>
                                    </div>
                                    <div class="lp-bt">
                                        <div class="lp-block">
                                            <div class="lp-l">{{__('auth.hesabn_yoxdur')}}</div>
                                            <div class="lp-r"><a href="{{route('advertiser_register', app()->getLocale())}}">{{__('auth.register')}}</a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="lp-col">
                                <div class="ap-right">
                                    <h2 class="z-text">{{__('auth.publisher_title')}}</h2>
                                    <div class="z-button">
                                        <a href="{{route('publisher_login', app()->getLocale())}}">{{__('auth.login')}}</a>
                                    </div>
                                    <div class="lp-bt">
                                        <div class="lp-block">
                                            <div class="lp-l">{{__('auth.hesabn_yoxdur')}}</div>
                                            <div class="lp-r"><a href="{{route('publisher_register', app()->getLocale())}}">{{__('auth.register')}}</a></div>
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
