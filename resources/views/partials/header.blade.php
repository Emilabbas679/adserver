<!-- Header start -->
<div class="header">
	<div class="mob-h">
		<div class="m-menu"></div>
		<div class="m-logo">
			<a href="{{route('home')}}"></a>
		</div>
	</div>
    <div class="h-right">

        <div class="h-links" >
            <ul>
                <li class=""><a href="{{route('user_login_type', ['lang' => app()->getLocale(), 'type' => 'advertiser'])}}">{{__('adnetwork.user_advertiser_login')}}</a></li>
                <li class=""><a href="{{route('user_login_type', ['lang' => app()->getLocale(), 'type' => 'publisher'])}}">{{__('adnetwork.user_publisher_login')}}</a></li>
            </ul>
        </div>


		<div class="language">
            @php
                $lang = app()->getLocale();
                $route = url()->current();
                if(\Request::route() and \Request::route()->getName() == 'dashboard')
                    $route = env('APP_URL').'/'.app()->getLocale().'/';
            @endphp
			<span>{{strtoupper($lang)}}</span>
			<ul>
                @if($lang != 'en')
				<li><a href="{{str_replace("/".app()->getLocale().'/', '/en/', $route)}}">EN</a></li>
                    @endif
                @if($lang != 'ru')
				<li><a href="{{str_replace("/".app()->getLocale().'/', '/ru/', $route)}}">RU</a></li>
                    @endif
                @if($lang != 'tr')
				<li><a href="{{str_replace("/".app()->getLocale().'/', '/tr/', $route)}}">TR</a></li>
                    @endif
                @if($lang != 'az')
				<li><a href="{{str_replace("/".app()->getLocale().'/', '/az/', $route)}}">AZ</a></li>
                    @endif
			</ul>
		</div>
        <div class="h-links">
            <ul>
                <li class="hlp"><a href="#">{{__('adnetwork.support')}}</a></li>
                <li class="faq"><a href="#">{{__('adnetwork.faq')}}</a></li>
            </ul>
        </div>
        <div class="notifications"><span>6</span></div>
        <div class="my-profile"><img src="/images/p/profile.jpg"></div>
        <div class="profile-block">
            <div class="pr-top">{{auth()->user()->name}}</div>
            <div class="pr-menu">
                <ul>
                    <li class="p-profile"><a href="{{route('profile_settings', app()->getLocale())}}">{{__('adnetwork.my_profile')}}</a></li>
                    <li class="p-settings"><a href="{{route('profile_settings', app()->getLocale())}}">{{__('adnetwork.profile_settings')}}</a></li>
                    <li class="p-logout"><a href="{{route('logout', app()->getLocale())}}">Çıxış</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Header end -->
