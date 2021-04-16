<!-- Main sidebar start -->
	<div class="main-sidebar">
		<div class="logo">
			<a href="{{route('home')}}"></a>
		</div>
		<div class="side-menu">
			<ul class="scrl">
				<li class="side-a">{{__('admin.main')}}</li>
				<li class="side-b  main  @if(\Request::route() and \Request::route()->getName() == 'dashboard' )  active @endif"><a href="{{route('home')}}"><i></i>{{__('admin.homepage')}}</a></li>
				<li class="side-a">{{__('admin.campaigns')}}</li>
				<li class="side-b companies  @if(\Request::route() and \Request::route()->getName() == 'campaign.index' )  active @endif"><a href="{{route('campaign.index', app()->getLocale())}}"><i></i><span>{{__('admin.campaign_list')}}</span></a></li>
				<li class="side-b main avgroup  @if(\Request::route() and \Request::route()->getName() == 'adset.index' )  active @endif"><a href="{{route('adset.index', app()->getLocale())}}"><i></i><span>{{__('admin.adset_group')}}</span></a></li>
				<li class="side-b avnetwork  @if(\Request::route() and \Request::route()->getName() == 'advert.index' )  active @endif"><a href="{{route('advert.index', app()->getLocale())}}"><i></i><span>{{__('admin.ads_advert')}}</span></a></li>
				<li class="side-a">{{__('admin.other')}}</li>
				<li class="side-b has-sub money">
					<a href="#"><i></i><span>{{__('admin.balance ')}}</span></a>
					<ul class="sub-menu">
						<li><a href="{{route('wallet_increase', app()->getLocale())}}">{{__('admin.increase_balance ')}}</a></li>
						<li><a href="{{route('wallet_history', app()->getLocale())}}">{{__('admin.balance_history')}}</a></li>
					</ul>
				</li>
                <li class="side-b avtranslate"><a href="{{route('admin.translations', app()->getLocale())}}"><i></i><span>{{__('admin.translations')}}</span></a></li>
            </ul>
		</div>
	</div>
	<!-- Main sidebar end -->
