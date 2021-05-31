<!-- Main sidebar start -->
	<div class="main-sidebar">
		<div class="logo">
			<a href="{{route('home')}}"></a>
		</div>

        <div class="side-menu">
			<ul class="scrl">
				<li class="side-a">{{__('adnetwork.home')}}</li>
				<li class="side-b  main  @if(\Request::route() and \Request::route()->getName() == 'dashboard' )  active @endif"><a href="{{route('home')}}"><i></i>{{__('adnetwork.home')}}</a></li>
				@if(user_login_type('advertiser'))
                    <li class="side-a">{{__('adnetwork.campaign_group')}}</li>
                    <li class="side-b companies  @if(\Request::route() and \Request::route()->getName() == 'campaign.index' )  active @endif"><a href="{{route('campaign.index', app()->getLocale())}}"><i></i><span>{{__('adnetwork.campaign_list')}}</span></a></li>
                    <li class="side-b main avgroup  @if(\Request::route() and \Request::route()->getName() == 'adset.index' )  active @endif"><a href="{{route('adset.index', app()->getLocale())}}"><i></i><span>{{__('adnetwork.adset_group')}}</span></a></li>
                    <li class="side-b avnetwork  @if(\Request::route() and \Request::route()->getName() == 'advert.index' )  active @endif"><a href="{{route('advert.index', app()->getLocale())}}"><i></i><span>{{__('adnetwork.ad_list')}}</span></a></li>
                @else
                    <li class="side-a">{{__('adnetwork.website_list')}}</li>
                    <li class="side-b   @if(\Request::route() and \Request::route()->getName() == 'site.index' )  active @endif"><a href="{{route('site.index', app()->getLocale())}}"><i></i><span>{{__('adnetwork.website_list')}}</span></a></li>
                    <li class="side-b   @if(\Request::route() and \Request::route()->getName() == 'zone.index' )  active @endif"><a href="{{route('zone.index', app()->getLocale())}}"><i></i><span>{{__('adnetwork.publisher_zone_list')}}</span></a></li>
                @endif




                <li class="side-a">{{__('adnetwork.other')}}</li>


                <li class="side-b has-sub money">
					<a href="#"><i></i><span>{{__('adnetwork.walletamount')}}</span></a>
					<ul class="sub-menu">
						<li><a href="{{route('wallet_increase', app()->getLocale())}}">{{__('adnetwork.increase_balance')}}</a></li>
						<li><a href="{{route('wallet_history', app()->getLocale())}}">{{__('adnetwork.balance_history')}}</a></li>
					</ul>
				</li>


                @if(check_permission('adnetwork.can_manage_accounting', $permissions))
                <li class="side-b has-sub v-3">
					<a href="#"><i></i><span>{{__('adnetwork.accounting')}}</span></a>
					<ul class="sub-menu">
						<li><a href="{{route('bank.accounting.index', app()->getLocale())}}">{{__('adnetwork.bank_accounting')}}</a></li>
						<li><a href="{{route('bank.accounting.monthly', app()->getLocale())}}">{{__('adnetwork.bank_accounting_monthly')}}</a></li>
						<li><a href="{{route('bank.finance.campaign.index', app()->getLocale())}}">{{__('adnetwork.finance_campaigns')}}</a></li>
						<li><a href="{{route('bank.accounts.index', app()->getLocale())}}">{{__('adnetwork.bank_accounts')}}</a></li>
						<li><a href="{{route('bank.pub_wallet.index', app()->getLocale())}}">{{__('adnetwork.pub_all_wallet')}}</a></li>
						<li><a href="{{route('bank.ref_wallet.index', app()->getLocale())}}">{{__('adnetwork.ref_all_wallet')}}</a></li>
						<li><a href="{{route('bank.cost.index', app()->getLocale())}}">{{__('adnetwork.costs')}}</a></li>
						<li><a href="{{route('bank.impression.stats.monthly', app()->getLocale())}}">{{__('adnetwork.impression_stats_monthly')}}</a></li>
						<li><a href="{{route('bank.actions.index', app()->getLocale())}}">{{__('adnetwork.bank_actions')}}</a></li>
					</ul>
				</li>
                @endif
                @if(check_permission('adnetwork.can_manage_agency', $permissions))
                <li class="side-b @if(\Request::route() and \Request::route()->getName() == 'agency.index' )  active @endif"><a href="{{route('agency.index', app()->getLocale())}}"><i></i><span>{{__('adnetwork.agency')}}</span></a></li>
                @endif

                @if(check_permission('user.can_manage_all_users', $permissions))
                <li class="side-b @if(\Request::route() and \Request::route()->getName() == 'users.index' )  active @endif"><a href="{{route('users.index', app()->getLocale())}}"><i></i><span>{{__('adnetwork.users')}}</span></a></li>
                @endif


				<li class="side-b avtranslate"><a href="{{route('admin.translations', app()->getLocale())}}"><i></i><span>{{__('adnetwork.lang')}}</span></a></li>
            </ul>
		</div>
	</div>
	<!-- Main sidebar end -->
