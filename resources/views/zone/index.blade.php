@extends('layouts.app')
@section('title', __('adnetwork.publisher_zone_list'))
@section('content')
    <div class="content-inner adset">
        <div class="breadcrumb">
            <ul>
                <li><a href="{{route('home', app()->getLocale())}}">{{__('adnetwork.home')}}</a></li>
                <li><span>{{__('adnetwork.publisher_zone_list')}}</span></li>
            </ul>
        </div>
        @include('partials.cards')
        @include('flash-message')
        <div class="a-block mb-20">
            <div class="a-block-head">{{__('adnetwork.search')}}</div>
            <div class="a-block-body">
                <form action="{{route('zone.index', app()->getLocale())}}" method="get">
                    <div class="form-group mb-0">
						<div class="cols w-mob">
                            <div class="col-item col-d">
                                <div class="form-select">
                                    <select name="format_type_id" id="format_type_id" class="select-ns" data-placeholder="{{__('adnetwork.all')}}">
                                        <option value="0" {{selected_exist($request, 'format_type_id', '0')}}>{{__('adnetwork.all')}}</option>
                                        <option value="261" {{selected_exist($request, 'format_type_id', '261')}}>{{__('adnetwork.ad_static_name_261')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-item col-d">
                                <div class="form-select">
                                    <select name="dimension_id" id="dimension_id" class="select-ns" data-placeholder="{{__('adnetwork.all')}}">
                                        <option value="0"  {{selected_exist($request, 'dimension_id', '0')}}>{{__('adnetwork.all')}}</option>
                                        <option value="3"  {{selected_exist($request, 'dimension_id', '3')}}>728x90</option>
                                        <option value="5"  {{selected_exist($request, 'dimension_id', '5')}}>320x100</option>
                                        <option value="6"  {{selected_exist($request, 'dimension_id', '6')}}>300x600</option>
                                        <option value="7"  {{selected_exist($request, 'dimension_id', '7')}}>300x250</option>
                                        <option value="12" {{selected_exist($request, 'dimension_id', '12')}}>468x60</option>
                                        <option value="16" {{selected_exist($request, 'dimension_id', '16')}}>240x400</option>
                                        <option value="17" {{selected_exist($request, 'dimension_id', '17')}}>160x600</option>
                                        <option value="30" {{selected_exist($request, 'dimension_id', '30')}}>{{__('adnetwork.ad_static_dimension_name_30')}}</option>
                                    </select>
                                </div>
                            </div>
							<div class="col-item col-d">
								<div class="form-select">
									<select name="status_id" id="status_id" class="select-ns" data-placeholder="{{__('adnetwork.all')}}">
                                        <option value="0" {{selected_exist($request, 'status_id', '0')}}>{{__('adnetwork.all')}}</option>

                                    @foreach(status_options() as $status)
                                            <option value="{{$status['id']}}" {{selected_exist($request, 'status_id', $status['id'])}}>{{$status['text']}}</option>
                                        @endforeach
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
            <div class="a-block-head with-b">{{__('adnetwork.website_list')}}
                <a href="{{route('zone.create', app()->getLocale())}}" class="a-button b-gr f-right with-icon add b-small">{{__('adnetwork.publisher_zone_add')}}</a>

            </div>
            <div class="a-block-body">

                @if(count($items)>0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>

                            <tr>
                                <th>{{__('adnetwork.id')}}</th>
                                <th>{{__('adnetwork.tools')}}</th>
                                <th>{{__('adnetwork.website_name')}}</th>
                                <th>{{__('adnetwork.zone_name')}}</th>
                                <th>{{__('adnetwork.status')}}</th>
                                <th>{{__('adnetwork.dimension_id')}}</th>
                                <th>{{__('adnetwork.format_type_id')}}</th>
                                <th>{{__('adnetwork.earning_cpm')}}</th>
                                <th>{{__('adnetwork.earning_cpc')}}</th>
                                <th>{{__('adnetwork.spent_cpm')}}</th>
                                <th>{{__('adnetwork.spent_cpc')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $key=>$item)
                                <tr>
                                    <td>{{$item['slot_id']}}</td>
                                    <td>
                                        <div class="tools"></div>
                                        <div class="tools-list">
                                            <ul>
                                                <li class="edit"><a class="dropdown-item" href="{{route('zone.edit', ['lang'=> app()->getLocale(), 'id' => $item['slot_id']])}}">{{__('adnetwork.edit')}}</a></li>
                                                @if($item['status_id'] != 10)
                                                    <li class="stop-a"><a class="dropdown-item" href="{{route('zone.status', ['lang' => app()->getLocale(), 'id' => $item['slot_id'], 'status_id' => 10])}}">{{__('adnetwork.admin_pause')}}</a></li>
                                                @endif
                                                @if($item['status_id'] != 40)
                                                    <li class="stop-b"><a class="dropdown-item" href="{{route('zone.status', ['lang' => app()->getLocale(), 'id' => $item['slot_id'], 'status_id' => 40])}}">{{__('adnetwork.pause')}}</a></li>
                                                @endif
                                                @if($item['status_id'] != 27)
                                                    <li class="delete"><a class="dropdown-item" href="{{route('zone.status', ['lang' => app()->getLocale(), 'id' => $item['slot_id'], 'status_id' => 27])}}">{{__('adnetwork.delete')}}</a></li>
                                                @endif
                                                @if($item['status_id'] != 11)
                                                    <li class="activate"><a class="dropdown-item" href="{{route('zone.status', ['lang' => app()->getLocale(), 'id' => $item['slot_id'], 'status_id' => 11])}}">{{__('adnetwork.activate')}}</a></li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                    <td>{{$item['website']}}</td>
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
                                    <td class="t-center">{{get_dimension($item['dimension_id'])}}</td>
                                    <td class="t-center">{{get_format_type($item['format_type_id'])}}</td>
                                    <td class="t-center">{{$item['earning_cpm']}}</td>
                                    <td class="t-center">{{$item['earning_cpc']}}</td>
                                    <td class="t-center">{{$item['spent_cpm']}}</td>
                                    <td class="t-center">{{$item['spent_cpc']}}</td>
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
