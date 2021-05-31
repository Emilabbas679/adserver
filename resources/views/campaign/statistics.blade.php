@extends('layouts.app')
@section('title', $campaign['name'])
@section('content')
    <div class="content-inner campaign">
        <div class="breadcrumb">
            <ul>
                <li><a href="{{route('dashboard', app()->getLocale())}}">Smartbee</a></li>
                <li><span>İdarə paneli</span></li>
            </ul>
        </div>

        @include('partials.cards')
        @include('flash-message')
        <div class="a-block mb-20">
            <div class="a-block-head">{{__('adnetwork.search')}}</div>
            <div class="a-block-body">
                <form action="{{route('campaign.statistics', ['lang'=>app()->getLocale(), 'id' => $campaign['campaign_id']])}}" method="get">
                    <div class="form-group mb-0">
						<div class="cols w-mob">
							<div class="col-item col-d">
								<div class="form-select">
									<select name="status_id" id="country" class="select-ns" data-placeholder="{{__('placeholders.all_statuses')}}">
									</select>
								</div>
							</div>
							<div class="col-item col-d">
								<div class="form-input">
									<input id="text" type="text" name="searchQuery" data-toggle="datepicker">
									</select>
								</div>
							</div> 
							<div class="col-item col-d">
								<div class="form-input">
									<input id="text" type="text" name="searchQuery">
									</select>
								</div>
							</div>
							<div class="col-item col-e"><button type="submit" class="a-button b-orange">{{__('adnetwork.search')}}</button></div>
						</div>
                    </div>
                </form>
            </div>
        </div>
        <div class="a-block">
            <div class="a-block-head">{{$campaign['name']}}</div>
            <div class="a-block-body">

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>{{__('adnetwork.id')}}</th>
                            <th>{{__('adnetwork.name')}}</th>
                            <th>{{__('adnetwork.impression')}}</th>
                            <th>{{__('adnetwork.unique_impression_daily')}}</th>
                            <th>{{__('adnetwork.reach')}}</th>
                            <th>{{__('adnetwork.click')}}</th>
                            <th>{{__('adnetwork.unique_clicks')}}</th>
                            <th>{{__('adnetwork.site_imptessions')}}</th>
                            <th>{{__('adnetwork.site_clicks')}}</th>
                            <th>{{__('adnetwork.ctr')}}</th>
                            <th>{{__('adnetwork.eCPC')}}</th>
                            <th>{{__('adnetwork.video_start')}}</th>
                            <th>{{__('adnetwork.25_percent_kvartil')}}</th>
                            <th>{{__('adnetwork.50_percent_kvartil')}}</th>
                            <th>{{__('adnetwork.75_percent_kvartil')}}</th>
                            <th>{{__('adnetwork.100_percent_kvartil')}}</th>
                            <th>{{__('adnetwork.ads_cost')}}</th>
                            <th>{{__('adnetwork.eCPM')}}</th>
                        </tr>
                        </thead>
                        <tbody>
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
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
@endsection
@section('js')
	<script type="text/javascript" src="/js/datepicker.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            var table = $('.table').DataTable({
                searching: false,
                lengthChange: false,
                paging: false,
                info: false,
                "aoColumnDefs": [
                    { "bSortable": false, "aTargets": 1 },
                ]
            });

            // table.columns( [5,6,7,8,9,10,11,12,13,14,15] ).visible( false );
            // table.columns.orderable( [5,6,7,8,9,10,11,12,13,14,15] );

        });
    </script>

    <script>
        $('#users').select2({
            placeholder: "{{__('placeholders.username')}}",
            language: {
                searching: function() {
                    return "{{__('placeholders.searching')}}";
                }
            },

            ajax: {
                url: "/api/select/users",
                data: function(params) {
                    var query = {
                        search: params.term,
                        page: params.page || 1
                    }
                    return query;
                },
                delay: 600,
                cache: true
            }
        });
    </script>

	<script>
	$('[data-toggle="datepicker"]').datepicker({
		autoHide: true,
		autoPick: true,
		format: 'dd/mm/yyyy'
	});
	</script>


@endsection
