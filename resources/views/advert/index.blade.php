@extends('layouts.app')
@section('title', __('adnetwork.ad_list'))
@section('content')
    <div class="content-inner">
        <div class="breadcrumb">
            <ul>
                <li><a href="{{route('home', app()->getLocale())}}">{{__('adnetwork.home')}}</a></li>
                <li><span>{{__('adnetwork.ad_list')}}</span></li>
            </ul>
        </div>
        <!-- Cards start -->
        @include('partials.cards')
        @include('flash-message')
        <!-- Cards end -->

        <div class="a-block mb-20">
            <div class="a-block-head">{{__('adnetwork.search')}}</div>
            <div class="a-block-body">
                <form action="{{route('advert.index', app()->getLocale())}}" method="get">
                    <div class="form-group">
						<div class="cols">
							<div class="col-item col-a">
								<div class="form-input">
									<input id="text" type="text" name="searchQuery" @if($request->has('searchQuery')) value="{{$request->searchQuery}}" @endif placeholder="{{__('adnetwork.search')}}">
								</div>
							</div>
							<div class="col-item col-a">
								<div class="form-select">
									<select name="status_id" id="country" class="select-ns" data-placeholder="{{__('adnetwork.all')}}">
                                        <option value="">{{__('adnetwork.all')}}</option>
                                        <option value="11" {{selected_exist($request, 'status_id', 11)}}>{{__('adnetwork.ad_static_status_11')}}</option>
                                        <option value="12" {{selected_exist($request, 'status_id', 12)}}>{{__('adnetwork.ad_static_status_12')}}</option>
                                        <option value="17" {{selected_exist($request, 'status_id', 17)}}>{{__('adnetwork.ad_static_status_17')}}</option>
                                        <option value="10" {{selected_exist($request, 'status_id', 10)}}>{{__('adnetwork.ad_static_status_10')}}</option>
                                        <option value="27" {{selected_exist($request, 'status_id', 27)}}>{{__('adnetwork.ad_static_status_27')}}</option>
                                        <option value="40" {{selected_exist($request, 'status_id', 40)}}>{{__('adnetwork.ad_static_status_40')}}</option>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group mb-0">
						<div class="cols col-table">
							<div class="tb-item col-item col-a">
								<div class="form-select">
									<select name="format_type_id" class="select-ns" data-placeholder="{{__('adnetwork.all')}}">
										<option value="">{{__('adnetwork.formats')}}</option>
										<option value="10" {{selected_exist($request, 'format_type_id', 10)}}>{{__('adnetwork.ad_static_name_10')}}</option>
										<option value="11" {{selected_exist($request, 'format_type_id', 11)}}>{{__('adnetwork.ad_static_name_11')}}</option>
										<option value="12" {{selected_exist($request, 'format_type_id', 12)}}>{{__('adnetwork.ad_static_name_12')}}</option>
										<option value="15" {{selected_exist($request, 'format_type_id', 15)}}>{{__('adnetwork.ad_static_name_15')}}</option>
										<option value="79" {{selected_exist($request, 'format_type_id', 79)}}>{{__('adnetwork.ad_static_name_79')}}</option>
										<option value="83" {{selected_exist($request, 'format_type_id', 83)}}>{{__('adnetwork.ad_static_name_83')}}</option>
										<option value="260" {{selected_exist($request, 'format_type_id', 260)}}>{{__('adnetwork.ad_static_name_260')}}</option>
										<option value="261" {{selected_exist($request, 'format_type_id', 261)}}>{{__('adnetwork.ad_static_name_261')}}</option>
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
                                </div>
							</div>
							<div class="tb-item col-item"><button type="submit" class="a-button b-orange">{{__('adnetwork.search')}}</button></div>
						</div>
                    </div>
                </form>
            </div>
        </div>



        <div class="cols">
            <div class="col-item">
                <div class="a-block">
                    <div class="a-block-head">{{__('adnetwork.ad_list')}}

                        <a href="{{route('advert.create', app()->getLocale())}}" class="a-button b-gr f-right with-icon add b-small">{{__('adnetwork.ad_add')}}</a>

                    </div>
                    <div class="a-block-body">
                        @if(count($items)>0)
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>

                                    <tr>
                                        <th>{{__('adnetwork.id')}}</th>
                                        <th>{{__('adnetwork.tools')}}</th>
                                        <th>{{__('adnetwork.user_email_or_name')}}</th>
                                        <th>{{__('adnetwork.ad_list')}}</th>
                                        <th>{{__('adnetwork.status')}}</th>
                                        <th>{{__('adnetwork.statistics')}}</th>
                                        <th>{{__('adnetwork.model')}}</th>
                                        <th>{{__('adnetwork.unit_cost_max')}}</th>
                                        <th>{{__('adnetwork.unit_cost_min')}}</th>
                                        <th>{{__('adnetwork.ref_user_name')}}</th>
                                        <th>{{__('adnetwork.ref_user_name_rate')}}</th>
                                        <th>{{__('adnetwork.budget_planned')}}</th>
                                        <th>{{__('adnetwork.budget_spent')}}</th>
                                        <th>{{__('adnetwork.end_date')}}</th>

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
                                                        <li class="edit"><a class="dropdown-item" href="{{route('advert.edit', ['lang'=> app()->getLocale(), 'id' => $item['ad_id']])}}">{{__('adnetwork.edit')}}</a></li>
                                                        @if($item['status_id'] != 10)
                                                            <li class="stop-a"><a class="dropdown-item" href="{{route('advert.status', ['lang' => app()->getLocale(), 'advert_id' => $item['ad_id'], 'status_id' => 10])}}">{{__('adnetwork.admin_pause')}}</a></li>
                                                        @endif
                                                        @if($item['status_id'] != 40)
                                                            <li class="stop-b"><a class="dropdown-item" href="{{route('advert.status', ['lang' => app()->getLocale(), 'advert_id' => $item['ad_id'], 'status_id' => 40])}}">{{__('adnetwork.pause')}}</a></li>
                                                        @endif
                                                        @if($item['status_id'] != 27)
                                                            <li class="delete"><a class="dropdown-item" href="{{route('advert.status', ['lang' => app()->getLocale(), 'advert_id' => $item['ad_id'], 'status_id' => 27])}}">{{__('adnetwork.delete')}}</a></li>
                                                        @endif
                                                        @if($item['status_id'] != 11)
                                                            <li class="activate"><a class="dropdown-item" href="{{route('advert.status', ['lang' => app()->getLocale(), 'advert_id' => $item['ad_id'], 'status_id' => 11])}}">{{__('adnetwork.active')}}</a></li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </td>
                                            <td>{{$item['user_name']}}</td>
                                            <td>{{$item['name']}}</td>
                                            <td class="t-center">
                                            <span data-id="{{$item['status_id']}}" class="badge @if($item['status_id'] == 11) badge-success @elseif($item['status_id'] == 12) badge-info @elseif($item['status_id'] == 17) badge-warning @elseif($item['status_id'] == 10) badge-danger @elseif($item['status_id'] == 27) badge-danger @elseif($item['status_id'] == 40) badge-warning @endif ">
										        @if($item['status_id'] == 11)      {{__('adnetwork.ad_static_status_11')}}
                                                @elseif($item['status_id'] == 12)  {{__('adnetwork.ad_static_status_12')}}
                                                @elseif($item['status_id'] == 17)  {{__('adnetwork.ad_static_status_17')}}
                                                @elseif($item['status_id'] == 10)  {{__('adnetwork.ad_static_status_10')}}
                                                @elseif($item['status_id'] == 27)  {{__('adnetwork.ad_static_status_27')}}
                                                @elseif($item['status_id'] == 40)  {{__('adnetwork.ad_static_status_40')}}
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
            placeholder: "{{__('adnetwork.user_email_or_name')}}",
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
