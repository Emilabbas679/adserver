<!-- Header start -->
<div class="header">
    <div class="h-right">
        <div class="h-links">
            <ul>
                <li class="hlp"><a href="test">{{__('admin.support')}}</a></li>
                <li class="faq"><a href="test">{{__('admin.faq')}}</a></li>
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
