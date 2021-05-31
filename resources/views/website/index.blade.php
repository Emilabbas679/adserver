@extends('layouts.app')
@section('title', __('adnetwork.website_list'))
@section('css')


    @endsection
@section('content')
    <div class="content-inner adset">
        <div class="breadcrumb">
            <ul>
                <li><a href="{{route('home', app()->getLocale())}}">{{__('adnetwork.home')}}</a></li>
                <li><span>{{__('adnetwork.website_list')}}</span></li>
            </ul>
        </div>
        @include('partials.cards')
        @include('flash-message')
        <div class="a-block mb-20">
            <div class="a-block-head">{{__('adnetwork.search')}}</div>
            <div class="a-block-body">
                <form action="{{route('site.index', app()->getLocale())}}" method="get">
                    <div class="form-group mb-0">
						<div class="cols w-mob">
							<div class="col-item col-d">
								<div class="form-input">
									<input id="text" type="text" name="searchQuery" @if($request->has('searchQuery')) value="{{$request->searchQuery}}" @endif placeholder="{{__('adnetwork.searchQuery')}}">
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
            <div class="a-block-head with-b">{{__('adnetwork.website_list')}}</div>
            <div class="a-block-body">

                @if(count($items)>0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>

                            <tr>
                                <th>{{__('adnetwork.user_id')}}</th>
                                <th>{{__('adnetwork.id')}}</th>
                                <th>{{__('adnetwork.tools')}}</th>
                                <th>{{__('adnetwork.website_name')}}</th>
                                <th>{{__('adnetwork.status')}}</th>
                                <th>{{__('adnetwork.publisher_zone_list')}}</th>
                                <th>{{__('adnetwork.earning_cpm')}}</th>
                                <th>{{__('adnetwork.earning_cpc')}}</th>
                                <th>{{__('adnetwork.spent_cpm')}}</th>
                                <th>{{__('adnetwork.spent_cpc')}}</th>
                                <th>{{__('adnetwork.stats')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $key=>$item)
                                <tr>
                                    <td>{{$item['user_id']}}</td>
                                    <td>{{$item['site_id']}}</td>
                                    <td>
                                        <div class="tools"></div>
                                        <div class="tools-list">
                                            <ul>
                                                <li class="edit"><a class="dropdown-item" href="{{route('site.edit', ['lang'=> app()->getLocale(), 'id' => $item['site_id']])}}">{{__('adnetwork.edit')}}</a></li>
                                                @if($item['status_id'] != 10)
                                                    <li class="stop-a"><a class="dropdown-item" ><span class="mbtn" data-target="#websites" style="padding: 0px" data-site-id="{{$item['site_id']}}" data-status-id="10">{{__('adnetwork.admin_pause')}}</span></a></li>
                                                @endif
                                                @if($item['status_id'] != 40)
                                                    <li class="stop-b"><a class="dropdown-item" ><span class="mbtn" data-target="#websites" style="padding: 0px" data-site-id="{{$item['site_id']}}" data-status-id="40">{{__('adnetwork.pause')}}</span></a></li>
                                                @endif
                                                @if($item['status_id'] != 27)
                                                    <li class="delete"><a class="dropdown-item" ><span class="mbtn" data-target="#websites" style="padding: 0px" data-site-id="{{$item['site_id']}}" data-status-id="27">{{__('adnetwork.delete')}}</span></a></li>
                                                @endif
                                                @if($item['status_id'] != 11)
                                                    <li class="activate"><a class="dropdown-item" ><span class="mbtn" data-target="#websites" style="padding: 0px" data-site-id="{{$item['site_id']}}" data-status-id="11">{{__('adnetwork.activate')}}</span></a></li>
                                                @endif



                                            </ul>
                                        </div>
                                    </td>
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
                                    <td class="t-center">{{$item['slot_count']}}</td>
                                    <td class="t-center">{{$item['earning_cpm']}}</td>
                                    <td class="t-center">{{$item['earning_cpc']}}</td>
                                    <td class="t-center">{{$item['spent_cpm']}}</td>
                                    <td class="t-center">{{$item['spent_cpc']}}</td>
                                    <td class="t-center"><a href="{{route('advert.statistic', ['lang'=>app()->getLocale(),'id'=>$item['site_id'], 'type'=> 'site'])}}" class="a-button with-icon fw-normal statistics">{{__('adnetwork.stats')}}</a></td>
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

    <div id="websites" class="modal">
        <div class="modal-wrap">
            <div class="modal-content">
                <div class="modal-a w-400">
                    <div class="modal-header">
                        <h2 class="md-title">{{__('adnetwork.submit')}}</h2>
                        <div class="x-close"></div>
                    </div>
                    <div class="modal-body">
                        <div class="ws-list">
                            <form action="{{route('site.status',app()->getLocale())}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label class="form-label" for="text">{{__('adnetwork.reason')}}</label>
                                    <div class="form-select">
                                        <textarea name="text" id="text" cols="15" style="width: 100%; max-width: 100%"></textarea>
                                    </div>
                                </div>
                                <input type="hidden" name="status_id" id="status_id">
                                <input type="hidden" name="site_id" id="site_id">
                                <div class="t-center">
                                    <button class="a-button b-green" type="submit">{{__('adnetwork.submit')}}</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $("span.mbtn").click(function (){
            $("#site_id").val($(this).attr('data-site-id'))
            $("#status_id").val($(this).attr('data-status-id'))
        })
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
