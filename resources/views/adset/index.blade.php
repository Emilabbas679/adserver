@extends('layouts.app')
@section('title', __('titles.adset'))
@section('content')
    <div class="content-inner">
        <div class="breadcrumb">
            <ul>
                <li><a href="{{route('home', app()->getLocale())}}">Smartbee</a></li>
                <li><span>İdarə paneli</span></li>
            </ul>
        </div>
        @include('partials.cards')
        @include('flash-message')
        <div class="a-block mb-20">
            <div class="a-block-head">{{__('adnetwork.search_in_adset')}}</div>
            <div class="a-block-body">
                <form action="{{route('adset.index', app()->getLocale())}}" method="get">
                    <div class="form-group mb-0">
						<div class="cols col-table">
							<div class="tb-item col-item col-b">
								<div class="form-input">
									<input id="text" type="text" name="searchQuery" @if($request->has('searchQuery')) value="{{$request->searchQuery}}" @endif placeholder="{{__('adnetwork.group')}}">
								</div>
							</div>
							<div class="tb-item col-item col-b">
								<div class="form-select">
									<select name="status_id" id="country" class="select-ns" data-placeholder="{{__('adnetwork.all_statuses')}}">
										<option value="">{{__('adnetwork.all_statuses')}}</option>
										<option value="11" {{selected_exist($request, 'status_id', 11)}}>{{__('adnetwork.active')}}</option>
										<option value="12" {{selected_exist($request, 'status_id', 12)}}>{{__('adnetwork.pending')}}</option>
										<option value="17" {{selected_exist($request, 'status_id', 17)}}>{{__('adnetwork.user_stopped')}}</option>
										<option value="10" {{selected_exist($request, 'status_id', 10)}}>{{__('adnetwork.admin_stopped')}}</option>
										<option value="27" {{selected_exist($request, 'status_id', 27)}}>{{__('adnetwork.deleted')}}</option>
										<option value="40" {{selected_exist($request, 'status_id', 40)}}>{{__('adnetwork.pause')}}</option>
									</select>
								</div>
							</div>
							<div class="tb-item col-item col-b">
								<div class="form-select">
									<select name="user_id" id="users" style="width: 100%"  data-live-search="true">
										@if(count($user_api)>0)
											<option value="{{$user_api['user_id']}}" selected>{{$user_api['email']}}</option>
										@endif
									</select>

									{{--                                        <input id="text" type="text" placeholder="{{__('adnetwork.username')}}">--}}
								</div>
							</div>
							<div class="tb-item col-item"><button type="submit" class="a-button b-orange">{{__('adnetwork.search')}}</button></div>
						</div>
                    </div>
                </form>
            </div>
        </div>

        <div class="a-block">
            <div class="a-block-head">{{__('adnetwork.adsets')}}
                <a href="{{route('adset.create', app()->getLocale())}}" class="a-button b-orange" style="float: right">{{__('adnetwork.create')}}</a>

            </div>
            <div class="a-block-body">
                @if(count($items)>0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>

                            <tr>
                                <th>{{__('adnetwork.id')}}</th>
                                <th>{{__('adnetwork.tools')}}</th>
                                <th>{{__('adnetwork.username')}}</th>
                                <th>{{__('adnetwork.set_id_adset')}}</th>
                                <th>{{__('adnetwork.ads_count')}}</th>
                                <th>{{__('adnetwork.statistics')}}</th>
                                <th>{{__('adnetwork.budget_type')}}</th>
                                <th>{{__('adnetwork.planned_budget')}}</th>
                                <th>{{__('adnetwork.budget_cost')}}</th>
                                <th>{{__('adnetwork.status')}}</th>
                                <th>{{__('adnetwork.start_date')}}</th>
                                <th>{{__('adnetwork.end_date')}}</th>
                                <th>{{__('adnetwork.date')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $key=>$item)
                                <tr>
                                    <td>{{$item['set_id']}}</td>
                                    <td>
                                        <div class="tools"></div>
                                        <div class="tools-list">
                                            <ul>
                                                <li class="edit"><a class="dropdown-item" href="{{route('adset.edit', ['lang'=> app()->getLocale(), 'id' => $item['set_id']])}}">Düzəliş</a></li>
                                                @if($item['status_id'] != 10)
                                                    <li class="stop-a"><a class="dropdown-item" href="{{route('adset.status', ['lang' => app()->getLocale(), 'adset_id' => $item['set_id'], 'status_id' => 10])}}">{{__('adnetwork.admin_stop')}}</a></li>
                                                @endif
                                                @if($item['status_id'] != 40)
                                                    <li class="stop-b"><a class="dropdown-item" href="{{route('adset.status', ['lang' => app()->getLocale(), 'adset_id' => $item['set_id'], 'status_id' => 40])}}">{{__('adnetwork.pause')}}</a></li>
                                                @endif
                                                @if($item['status_id'] != 27)
                                                    <li class="delete"><a class="dropdown-item" href="{{route('adset.status', ['lang' => app()->getLocale(), 'adset_id' => $item['set_id'], 'status_id' => 27])}}">{{__('adnetwork.delete')}}</a></li>
                                                @endif
                                                @if($item['status_id'] != 11)
                                                    <li class="activate"><a class="dropdown-item" href="{{route('adset.status', ['lang' => app()->getLocale(), 'adset_id' => $item['set_id'], 'status_id' => 11])}}">{{__('adnetwork.activate')}}</a></li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                    <td>{{$item['user_name']}}</td>
                                    <td>{{$item['campaign_name']}}</td>
                                    <td>{{$item['count_ad']}}</td>
                                    <td class="t-center"><a href="{{route('advert.statistic', ['lang'=>app()->getLocale(),'id'=>$item['set_id'], 'type'=> 'adset'])}}" class="a-button with-icon fw-normal statistics">Statistika</a></td>
                                    <td>
                                        @if($item['budget_type'] == 1)  {{__('adnetwork.total')}} @else {{__('adnetwork.daily')}} @endif
                                    </td>
                                    <td>@if($item['budget_planned']) {{number_format($item['budget_planned'],2)}} @else 0 @endif</td>
                                    <td>@if($item['budget_spent']) {{number_format($item['budget_spent'],2)}} @else 0 @endif</td>
                                    <td class="t-center">
                                    <span data-id="{{$item['status_id']}}" class="badge @if($item['status_id'] == 11) badge-success @elseif($item['status_id'] == 12) badge-info @elseif($item['status_id'] == 17) badge-warning @elseif($item['status_id'] == 10) badge-danger @elseif($item['status_id'] == 27) badge-danger @elseif($item['status_id'] == 40) badge-warning @endif ">
                                        @if($item['status_id'] == 11) {{__('adnetwork.active')}}
                                        @elseif($item['status_id'] == 12)  {{__('adnetwork.pending')}}
                                        @elseif($item['status_id'] == 17) {{__('adnetwork.user_stopped')}}
                                        @elseif($item['status_id'] == 10)  {{__('adnetwork.admin_stopped')}}
                                        @elseif($item['status_id'] == 27) {{__('adnetwork.deleted')}}
                                        @elseif($item['status_id'] == 40) {{__('adnetwork.pause')}}
                                        @endif
                                    </span>
                                    </td>
                                    <td>{{date('Y-m-d H:i:s', $item['start_time'])}}</td>
                                    <td>{{date('Y-m-d H:i:s', $item['end_time'])}}</td>
                                    <td>{{date('Y-m-d H:i:s', strtotime($item['intime']))}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-warning alert-styled-right alert-dismissible">
                        {{__('adnetwork.empty_result')}}
                    </div>
                @endif
                <div class="pagination mt-20">
                    <ul>
                        {!! $pagination !!}
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
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
            placeholder: "{{__('adnetwork.username')}}",
            language: {
                searching: function() {
                    return "{{__('adnetwork.searching')}}";
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


@endsection
