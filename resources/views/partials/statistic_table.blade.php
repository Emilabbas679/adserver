
<div class="table-responsive">
    <table class="table">
        <thead>
        <tr>
            @if($stats_type == 'get_spent_ad')

            <th>{{__('adnetwork.id')}}</th>
            <th>{{__('adnetwork.name')}}</th>
            <th>{{__('adnetwork.impression')}}</th>
            <th>{{__('adnetwork.unique_impression')}}</th>
            <th>{{__('adnetwork.reach')}}</th>
            <th>{{__('adnetwork.click')}}</th>
            <th>{{__('adnetwork.unique_click')}}</th>
            <th>{{__('adnetwork.site_impression')}}</th>
            <th>{{__('adnetwork.site_click')}}</th>
            <th>{{__('adnetwork.ctr')}}</th>
            <th>{{__('adnetwork.eCPC')}}</th>
            <th>{{__('adnetwork.video_start')}}</th>
            <th>{{__('adnetwork.firstquartile')}}</th>
            <th>{{__('adnetwork.midpoint')}}</th>
            <th>{{__('adnetwork.thirdquartile')}}</th>
            <th>{{__('adnetwork.complete')}}</th>
            <th>{{__('adnetwork.spent_amount')}}</th>
            <th>{{__('adnetwork.ecpm')}}</th>
            @elseif($stats_type == 'get_spent_site')

                <th>{{__('adnetwork.domain')}}</th>
                <th>{{__('adnetwork.impression')}}</th>
                <th>{{__('adnetwork.click')}}</th>
                <th>{{__('adnetwork.unique_impression')}}</th>
                <th>{{__('adnetwork.reach')}}</th>
                <th>{{__('adnetwork.unique_click')}}</th>
                <th>{{__('adnetwork.video_start')}}</th>
                <th>{{__('adnetwork.firstquartile')}}</th>
                <th>{{__('adnetwork.midpoint')}}</th>
                <th>{{__('adnetwork.thirdquartile')}}</th>
                <th>{{__('adnetwork.complete')}}</th>
                <th>{{__('adnetwork.spent_amount')}}</th>
                <th>{{__('adnetwork.ecpm')}}</th>

            @else
                <th>{{__('adnetwork.day')}}</th>
                <th>{{__('adnetwork.impression')}}</th>
                <th>{{__('adnetwork.click')}}</th>
                <th>{{__('adnetwork.unique_click')}}</th>
                <th>{{__('adnetwork.reach')}}</th>
                <th>{{__('adnetwork.unique_impression')}}</th>
                <th>{{__('adnetwork.spent_amount')}}</th>

            @endif

        </tr>
        </thead>
        <tbody>
            @if($stats_type == 'get_spent_ad')
                @foreach($items as $item)
                    <tr>
                        <td>{{$item['ad_id']}}</td>
                        <td>{{$item['name']}}</td>
                        <td>{{$item['impression']}}</td>
                        <td>{{$item['unique_impression']}}</td>
                        <td>{{$item['reach']}}</td>
                        <td>{{$item['click']}}</td>
                        <td>{{$item['unique_click']}}</td>
                        <td>{{$item['site_impression']}}</td>
                        <td>{{$item['site_click']}}</td>
                        <td>@if($item['site_impression'] > 0) {{ number_format(($item['site_click'] / $item['site_impression'] *100 ),2) }}   @else 0 @endif</td>
                        <td>@if($item['site_click'] > 0){{ number_format(($item['publisher_amount'] / $item['site_click']),2) }}   @else 0 @endif</td>
                        <td>@if($item['video_start'] > 0 ){{number_format($item['video_start'],2)}} @else 0 @endif</td>
                        <td>@if($item['firstQuartile'] > 0 ){{number_format($item['firstQuartile'],2)}}@else 0 @endif</td>
                        <td>@if($item['midpoint'] > 0 ){{number_format($item['midpoint'],2)}}@else 0 @endif</td>
                        <td>@if($item['thirdQuartile'] > 0 ){{number_format($item['thirdQuartile'],2)}}@else 0 @endif</td>
                        <td>@if($item['complete'] > 0 ){{number_format($item['complete'],2)}}@else 0 @endif</td>
                        <td>@if($item['spent_amount'] > 0 ){{number_format($item['spent_amount'], 2)}}@else 0 @endif</td>
                        <td>@if($item['site_impression'] > 0){{ number_format(($item['publisher_amount'] / $item['site_impression'] * 1000),2) }}@else  - @endif</td>
                    </tr>

                    @endforeach

            @elseif($stats_type == 'get_spent_site')

                @foreach($items as $item)
                    <tr>
                        <td>{{$item['domain']}}</td>
                        <td>{{$item['impression']}}</td>
                        <td>{{$item['click']}}</td>
                        <td>{{$item['unique_impression']}}</td>
                        <td>{{$item['reach']}}</td>
                        <td>{{$item['unique_click']}}</td>
                        <td>@if($item['video_start'] > 0 ){{number_format($item['video_start'],2)}} @else 0 @endif</td>
                        <td>@if($item['firstQuartile'] > 0 ){{number_format($item['firstQuartile'],2)}}@else 0 @endif</td>
                        <td>@if($item['midpoint'] > 0 ){{number_format($item['midpoint'],2)}}@else 0 @endif</td>
                        <td>@if($item['thirdQuartile'] > 0 ){{number_format($item['thirdQuartile'],2)}}@else 0 @endif</td>
                        <td>@if($item['complete'] > 0 ){{number_format($item['complete'],2)}}@else 0 @endif</td>
                        <td>@if($item['spent_amount'] > 0 ){{number_format($item['spent_amount'], 2)}}@else 0 @endif</td>
                        <td>@if($item['site_impression'] > 0){{ number_format(($item['publisher_amount'] / $item['site_impression'] * 1000),2) }}@else  - @endif</td>

                    </tr>

                @endforeach
            @elseif($stats_type == 'get_spent_daily')
                @foreach($items as $item)
                    <tr>
                        <td>{{$item['day']}}</td>
                        <td>{{$item['impression']}}</td>
                        <td>{{$item['click']}}</td>
                        <td>{{$item['unique_click']}}</td>
                        <td>{{$item['reach']}}</td>
                        <td>{{$item['unique_click']}}</td>
                        <td>{{$item['spent_amount']}}</td>
                    </tr>

                @endforeach


            @endif

        </tbody>
    </table>
</div>
