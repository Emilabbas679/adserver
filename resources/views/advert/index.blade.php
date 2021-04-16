@extends('layouts.app')
@section('title', __('titles.advert'))
@section('content')
    <div class="content-inner">
        <div class="breadcrumb">
            <ul>
                <li><a href="{{route('home', app()->getLocale())}}">Smartbee</a></li>
                <li><span>İdarə paneli</span></li>
            </ul>
        </div>
        <!-- Cards start -->
        @include('partials.cards')
        @include('flash-message')
        <!-- Cards end -->

        <div class="a-block mb-20">
            <div class="a-block-head">{{__('admin.search_in_advert')}}</div>
            <div class="a-block-body">
                <form action="{{route('advert.index', app()->getLocale())}}" method="get">
                    <div class="form-group">
						<div class="cols">
							<div class="col-item col-a">
								<div class="form-input">
									<input id="text" type="text" name="searchQuery" @if($request->has('searchQuery')) value="{{$request->searchQuery}}" @endif placeholder="{{__('adnetwork.search_in_advert')}}">
								</div>
							</div>
							<div class="col-item col-a">
								<div class="form-select">
									<select name="status_id" id="country" class="select-ns" data-placeholder="{{__('adnetwork.all_statuses')}}">
										<option value="">{{__('adnetwork.all_statuses')}}</option>
										<option value="11" {{selected_exist($request, 'status_id', 11)}}>{{__('adnetwork.active')}}</option>
										<option value="12" {{selected_exist($request, 'status_id', 12)}}>{{__('adnetwork.pending')}}</option>
										<option value="17" {{selected_exist($request, 'status_id', 17)}}>{{__('adnetwork.user_stopped')}}</option>
										<option value="10" {{selected_exist($request, 'status_id', 10)}}>{{__('adnetwork.admin_stopped')}}</option>
										<option value="27" {{selected_exist($request, 'status_id', 27)}}>{{__('adnetwork.deleted')}}</option>
										<option value="40" {{selected_exist($request, 'status_id', 40)}}>{{__('adnetwork.pause_status')}}</option>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group mb-0">
						<div class="cols col-table">
							<div class="tb-item col-item col-a">
								<div class="form-select">
									<select name="format_type_id" class="select-ns" data-placeholder="{{__('placeholders.all_formats')}}">
										<option value="">{{__('adnetwork.formats')}}</option>
										<option value="10" {{selected_exist($request, 'format_type_id', 10)}}>{{__('adnetwork.code')}}</option>
										<option value="11" {{selected_exist($request, 'format_type_id', 11)}}>{{__('adnetwork.goruntulu_reklamlar')}}</option>
										<option value="12" {{selected_exist($request, 'format_type_id', 12)}}>{{__('adnetwork.news')}}</option>
										<option value="15" {{selected_exist($request, 'format_type_id', 15)}}>{{__('adnetwork.sticky_vertical_ads')}}</option>
										<option value="79" {{selected_exist($request, 'format_type_id', 79)}}>{{__('adnetwork.animation_banner_html5')}}</option>
										<option value="83" {{selected_exist($request, 'format_type_id', 83)}}>{{__('adnetwork.catfish')}}</option>
										<option value="260" {{selected_exist($request, 'format_type_id', 260)}}>{{__('adnetwork.interscroller')}}</option>
										<option value="261" {{selected_exist($request, 'format_type_id', 261)}}>{{__('adnetwork.inpage/pre-roll')}}</option>
									</select>
								</div>
							</div>

							<div class="tb-item col-item col-a">
								<div class="form-input">
									<select name="user_id" id="users" style="width: 100%"  data-live-search="true">
										@if(count($user_api)>0)
											<option value="{{$user_api['user_id']}}" selected>{{$user_api['email']}}</option>
										@endif
									</select>

									{{--                                        <input id="text" type="text" placeholder="{{__('placeholders.username')}}">--}}
								</div>
							</div>
							<div class="tb-item col-item"><button type="submit" class="a-button b-orange">{{__('admin.search')}}</button></div>
						</div>
                    </div>
                </form>
            </div>
        </div>



        <div class="cols">
            <div class="col-item">
                <div class="a-block">
                    <div class="a-block-head">Reklam elanları</div>
                    <div class="a-block-body">
                        @if(count($items)>0)
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>

                                    <tr>
                                        <th>{{__('tables.id')}}</th>
                                        <th>{{__('tables.tools')}}</th>
                                        <th>{{__('tables.username')}}</th>
                                        <th>{{__('tables.ads_adverts')}}</th>
                                        <th>{{__('tables.status')}}</th>
                                        <th>{{__('tables.statistics')}}</th>
                                        <th>{{__('tables.model')}}</th>
                                        <th>{{__('tables.max_price')}}</th>
                                        <th>{{__('tables.min_price')}}</th>
                                        <th>{{__('tables.ref_user')}}</th>
                                        <th>{{__('tables.ref_user_percent')}}</th>
                                        <th>{{__('tables.planned_budget')}}</th>
                                        <th>{{__('tables.cost_budget')}}</th>
                                        <th>{{__('tables.end_date')}}</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($items as $key=>$item)
                                        <tr>
                                            <td>{{$item['ad_id']}}</td>
                                            <td>
                                                <div class="tools"></div>
                                                <div class="tools-list">
                                                    <ul>
                                                        <li class="edit"><a class="dropdown-item" href="{{route('advert.edit', ['lang'=> app()->getLocale(), 'id' => $item['set_id']])}}">Düzəliş</a></li>
                                                        @if($item['status_id'] != 10)
                                                            <li class="stop-a"><a class="dropdown-item" href="{{route('adset.status', ['lang' => app()->getLocale(), 'adset_id' => $item['set_id'], 'status_id' => 10])}}">{{__('admin.admin_stop')}}</a></li>
                                                        @endif
                                                        @if($item['status_id'] != 40)
                                                            <li class="stop-b"><a class="dropdown-item" href="{{route('adset.status', ['lang' => app()->getLocale(), 'adset_id' => $item['set_id'], 'status_id' => 40])}}">{{__('admin.pause')}}</a></li>
                                                        @endif
                                                        @if($item['status_id'] != 27)
                                                            <li class="delete"><a class="dropdown-item" href="{{route('adset.status', ['lang' => app()->getLocale(), 'adset_id' => $item['set_id'], 'status_id' => 27])}}">{{__('admin.delete')}}</a></li>
                                                        @endif
                                                        @if($item['status_id'] != 11)
                                                            <li class="activate"><a class="dropdown-item" href="{{route('adset.status', ['lang' => app()->getLocale(), 'adset_id' => $item['set_id'], 'status_id' => 11])}}">{{__('admin.activate')}}</a></li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </td>
                                            <td>{{$item['user_name']}}</td>
                                            <td>{{$item['name']}}</td>
                                            <td class="t-center">
                                            <span data-id="{{$item['status_id']}}" class="badge @if($item['status_id'] == 11) badge-success @elseif($item['status_id'] == 12) badge-info @elseif($item['status_id'] == 17) badge-warning @elseif($item['status_id'] == 10) badge-danger @elseif($item['status_id'] == 27) badge-danger @elseif($item['status_id'] == 40) badge-warning @endif ">
                                                @if($item['status_id'] == 11) {{__('tables.active')}}
                                                @elseif($item['status_id'] == 12)  {{__('tables.pending')}}
                                                @elseif($item['status_id'] == 17) {{__('tables.user_stopped')}}
                                                @elseif($item['status_id'] == 10)  {{__('tables.admin_stopped')}}
                                                @elseif($item['status_id'] == 27) {{__('tables.deleted')}}
                                                @elseif($item['status_id'] == 40) {{__('tables.pause')}}
                                                @endif
                                            </span>
                                            </td>
                                            <td class="t-center"><a href="{{route('advert.statistic', ['lang'=>app()->getLocale(),'id'=>$item['ad_id'], 'type'=> 'advert'])}}" class="a-button with-icon fw-normal statistics">Statistika</a></td>
                                            <td>{{$item['model_id']}}</td>
                                            <td>{{$item['unit_cost_max']}}</td>
                                            <td>{{$item['unit_cost_min']}}</td>
                                            <td>{{$item['ref_user_id']}}</td>
                                            <td>{{$item['ref_share_rate']}}</td>
                                            <td>@if($item['budget_planned']) {{$item['budget_planned']}} @else 0 @endif</td>
                                            <td>@if($item['budget_spent']) {{number_format($item['budget_spent'],2)}} @else 0 @endif</td>
                                            <td>{{date('Y-m-d H:i:s', $item['end_time'])}}</td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-warning alert-styled-right alert-dismissible">
                                {{__('admin.empty_result')}}
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


@endsection
