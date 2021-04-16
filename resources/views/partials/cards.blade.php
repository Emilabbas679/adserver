{{--5926--}}
@php $stats = impression_stats(auth()->id()) @endphp


<div class="cards">
    <div class="card">
        <div class="card-a">
            <div class="card-top">
                <div class="crd view">{{__('adnetwork.impression')}}</div>
{{--                <span class="prc pos">+45%</span>--}}
            </div>
            <div class="card-count">@if(isset($stats['today']))   {{$stats['today']['impression']}} @else 0 @endif</div>
            <div class="card-extra">{{__('adnetwork.impression')}}</div>
        </div>
    </div>
    <div class="card">
        <div class="card-a">
            <div class="card-top">
                <div class="crd click">{{__('adnetwork.click')}}</div>
{{--                <span class="prc neg">-11%</span>--}}
            </div>
            <div class="card-count">@if(isset($stats['today']))  {{$stats['today']['click']}}  @else 0 @endif</div>
            <div class="card-extra">{{__('adnetwork.click')}}</div>
        </div>
    </div>
    <div class="card">
        <div class="card-a">
            <div class="card-top">
                <div class="crd money-a">{{__('adnetwork.budget_cost')}}</div>
{{--                <span class="prc pos">+67%</span>--}}
            </div>
            <div class="card-count">@if(isset($stats['today']))  {{number_format($stats['today']['spent_amount'], 2 )}} @else 0 @endif <span class="azn"></span></div>
            <div class="card-extra">{{__('adnetwork.today_budget_cost')}}</div>
        </div>
    </div>
    <div class="card">
        <div class="card-a">
            <div class="card-top">
                <div class="crd money-b">{{__('adnetwork.budget_cost')}}</div>
{{--                <span class="prc pos">+15%</span>--}}
            </div>
            <div class="card-count">@if(isset($stats['month']))  {{number_format($stats['month']['spent_amount'], 2 )}} @else 0 @endif <span class="azn"></span></div>
            <div class="card-extra">{{__('adnetwork.month_budget_cost')}}</div>
        </div>
    </div>
</div>
