@extends('layouts.app')
@section('title', __('adnetwork.users'))
@section('content')
    <div class="content-inner">
        <div class="breadcrumb">
            <ul>
                <li><a href="{{route('home', app()->getLocale())}}">Smartbee</a></li>
                <li><span>{{__('adnetwork.users')}}</span></li>
            </ul>
        </div>

        @include('partials.cards')
        @include('flash-message')
        <div class="a-block mb-20">
            <div class="a-block-head">{{__('adnetwork.search_in_users')}}</div>
            <div class="a-block-body">
                <form  method="get">
                    <div class="form-group mb-0">
                        <div class="cols w-mob">
                            <div class="col-item col-d">
                                <div class="form-input">
                                    <input id="text" type="text" name="search_name" @if($request->has('search_name')) value="{{$request->search_name}}" @endif placeholder="{{__('adnetwork.search_name')}}">
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

                            <div class="col-item col-d">
                                <div class="form-select">
                                    <select name="payment_info_status_id" id="payment_info_status" style="width: 100%"  data-live-search="true">
                                        @foreach(status_options() as $option)
                                            <option value="{{$option['id']}}" {{selected_exist($request, 'payment_info_status_id', $option['id'])}}>{{$option['text']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="col-item col-e">
                                <button type="submit" class="a-button b-orange b-block">{{__('adnetwork.search')}}</button>
                            </div>
                        </div>


                    </div>
                </form>
            </div>
        </div>
        <div class="a-block">
            <div class="a-block-head">{{__('adnetwork.users')}}</div>
            <div class="a-block-body">
                @if(count($items)>0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>{{__('adnetwork.id')}}</th>
                                <th>{{__('adnetwork.tools')}}</th>
                                <th>{{__('adnetwork.phone_number')}}</th>
                                <th>{{__('adnetwork.name')}}</th>
                                <th>{{__('adnetwork.email')}}</th>
                                <th>{{__('adnetwork.language_id')}}</th>
                                <th>{{__('adnetwork.group_id')}}</th>
                                <th>{{__('adnetwork.gender')}}</th>
                                <th>{{__('adnetwork.last_login')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>{{$item['user_id']}}</td>
                                    <td>
                                        <div class="tools"></div>
                                        <div class="tools-list">
                                            <ul>
                                                <li class="gain"><a class="dropdown-item" href="{{route('users.azerforum_revenue_daily', ['lang'=> app()->getLocale(), 'id' => $item['user_id']])}}">{{__('adnetwork.azerforum_revenue_daily')}}</a></li>
                                                <li class="stats"><a class="dropdown-item" href="{{route('users.stats', ['lang'=> app()->getLocale(), 'id' => $item['user_id']])}}">{{__('adnetwork.stats')}}</a></li>
                                                <li class="payment_info"><a class="dropdown-item" href="{{route('users.edit_payment', ['lang'=> app()->getLocale(), 'id' => $item['user_id']])}}">{{__('adnetwork.edit_payment_info')}}</a></li>

                                            </ul>
                                        </div>
                                    </td>
                                    <td>{{$item['phone']}}</td>
                                    <td>{{$item['full_name']}}</td>
                                    <td>{{$item['email']}}</td>
                                    <td>{{$item['language_id']}}</td>
                                    <td>{{$item['user_group_id']}}</td>
                                    <td>{{$item['gender']}}</td>
                                    <td>{{date('Y-m-d H:i', $item['last_login'])}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-warning alert-styled-right alert-dismissible">
                        {{__('adnetwork.not_found')}}
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
        $("#payment_info_status").select2()
    </script>

@endsection
