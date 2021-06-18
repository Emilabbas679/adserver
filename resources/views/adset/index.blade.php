@extends('layouts.app')
@section('title', __('adnetwork.adset_group'))
@section('content')
    <div class="content-inner adset">
        <div class="breadcrumb">
            <ul>
                <li><a href="{{route('home', app()->getLocale())}}">{{__('adnetwork.home')}}</a></li>
                <li><span>{{__('adnetwork.adset_group')}}</span></li>
            </ul>
        </div>
        @include('partials.cards')
        @include('flash-message')
        <div class="a-block mb-20">
            <div class="a-block-head">{{__('adnetwork.search')}}</div>
            <div class="a-block-body">
                <form action="{{route('adset.index', app()->getLocale())}}" method="get">
                    <div class="form-group mb-0">
						<div class="cols w-mob">
							<div class="col-item col-d">
								<div class="form-input">
									<input id="text" type="text" name="searchQuery" @if($request->has('searchQuery')) value="{{$request->searchQuery}}" @endif placeholder="{{__('adnetwork.adset_group')}}">
								</div>
							</div>
							<div class="col-item col-d">
								<div class="form-select">
									<select name="status_id" id="country" class="select-ns" data-placeholder="{{__('adnetwork.all')}}">
                                        @foreach(status_options() as $status)
                                            <option value="{{$status['id']}}" {{selected_exist($request, 'status_id', $status['id'])}}>{{$status['text']}}</option>
                                        @endforeach
									</select>
								</div>
							</div>
							<div class="col-item col-d">
								<div class="form-select">
									<select name="user_id" id="users" style="width: 100%"  data-live-search="true">
										@if(count($user_api)>0)
											<option value="{{$user_api['user_id']}}" selected>{{$user_api['email']}}</option>
										@endif
									</select>

								</div>
							</div>
							<div class="col-item col-e"><button type="submit" class="a-button b-orange b-block">{{__('adnetwork.search')}}</button></div>
						</div>
                    </div>
                </form>
            </div>
        </div>

        <div class="a-block">
            <div class="a-block-head with-b">{{__('adnetwork.adset_group')}}
                <a href="{{route('adset.create', app()->getLocale())}}" class="a-button b-gr f-right with-icon add b-small">{{__('adnetwork.adset_add')}}</a>

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
                                <th>{{__('adnetwork.set_id')}}</th>
                                <th>{{__('adnetwork.count_advert')}}</th>
                                <th>{{__('adnetwork.stats')}}</th>
                                <th>{{__('adnetwork.budget_type')}}</th>
                                <th>{{__('adnetwork.budget_planned')}}</th>
                                <th>{{__('adnetwork.budget_spent')}}</th>
                                <th>{{__('adnetwork.status')}}</th>
                                <th class="mw-100">{{__('adnetwork.start_date')}}</th>
                                <th class="mw-100">{{__('adnetwork.end_date')}}</th>
                                <th class="mw-100">{{__('adnetwork.date')}}</th>
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
                                                <li class="edit"><a class="dropdown-item" href="{{route('adset.edit', ['lang'=> app()->getLocale(), 'id' => $item['set_id']])}}">{{__('adnetwork.edit')}}</a></li>
                                                @if($item['status_id'] != 10)
                                                    <li class="stop-a"><a class="dropdown-item" href="{{route('adset.status', ['lang' => app()->getLocale(), 'adset_id' => $item['set_id'], 'status_id' => 10])}}">{{__('adnetwork.admin_pause')}}</a></li>
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


										@if($item['status_id'] == 11)      {{__('adnetwork.ad_static_status_11')}}
                                        @elseif($item['status_id'] == 12)  {{__('adnetwork.ad_static_status_12')}}
                                        @elseif($item['status_id'] == 17)  {{__('adnetwork.ad_static_status_17')}}
                                        @elseif($item['status_id'] == 10)  {{__('adnetwork.ad_static_status_10')}}
                                        @elseif($item['status_id'] == 27)  {{__('adnetwork.ad_static_status_27')}}
                                        @elseif($item['status_id'] == 40)  {{__('adnetwork.ad_static_status_40')}}
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
