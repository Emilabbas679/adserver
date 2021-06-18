@extends('layouts.app')
@section('title', __('adnetwork.fb_pages'))
@section('content')
    <div class="content-inner">
        <div class="breadcrumb">
            <ul>
                <li><a href="{{route('home', app()->getLocale())}}">Smartbee</a></li>
                <li><span>{{__('adnetwork.fb_pages')}}</span></li>
            </ul>
        </div>

        @include('partials.cards')
        @include('flash-message')
        <div class="a-block mb-20">
            <div class="a-block-head">{{__('adnetwork.search')}}</div>
            <div class="a-block-body">
                <form  method="get">
                    <div class="form-group mb-0">
                        <div class="cols w-mob">

                            <div class="col-item col-d">
                                <div class="form-input">
                                    <input id="text" type="text" name="searchQuery" @if($request->has('searchQuery')) value="{{$request->searchQuery}}" @endif placeholder="{{__('adnetwork.searchQuery')}}">
                                </div>
                            </div>
                            <div class="col-item col-d">
                                <div class="form-select">
                                    <select name="status" id="country" class="select-ns" data-placeholder="{{__('adnetwork.all')}}">
                                        <option value="" selected>{{__('adnetwork.all')}}</option>
                                        <option value="active" {{selected_exist($request, 'status', 'active')}}>{{__('adnetwork.active')}}</option>
                                        <option value="inactive" {{selected_exist($request, 'status', 'inactive')}}>{{__('adnetwork.inactive')}}</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-item col-d">
                                <div class="form-select">
                                    <select name="user_id" id="fb_pages" style="width: 100%"  data-live-search="true">
                                        @if(count($user_api)>0)
                                            <option value="{{$user_api['id']}}" selected>{{$user_api['name']}}</option>
                                        @endif
                                    </select>
                                </div>
                            </div>



                            <div class="tb-item col-item">
                                <button type="submit" class="a-button b-orange">{{__('adnetwork.search')}}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="a-block">
            <div class="a-block-head">{{__('adnetwork.users')}}
                <a href="{{route('fb_page.create', app()->getLocale())}}" class="a-button b-gr f-right with-icon add b-small">{{__('adnetwork.add_user')}}</a>
            </div>
            <div class="a-block-body">
                @if(count($items)>0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>{{__('adnetwork.id')}}</th>
                                <th>{{__('adnetwork.tools')}}</th>
                                <th>{{__('adnetwork.name')}}</th>
                                <th>{{__('adnetwork.status')}}</th>
                                <th>{{__('adnetwork.user_count')}}</th>
                                <th>{{__('adnetwork.intime')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>{{$item['id']}}</td>
                                    <td>
                                        <div class="tools"></div>
                                        <div class="tools-list">
                                            <ul>
                                                <li class="edit"><a class="dropdown-item" href="{{route('fb_page.edit', ['lang'=> app()->getLocale(), 'id' => $item['id']])}}">{{__('adnetwork.edit')}}</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td>{{$item['title']}}</td>
                                    <td>{{$item['status']}}</td>
                                    <td>{{$item['user_count']}}</td>
                                    <td>{{date('Y-m-d', strtotime($item['intime']))}}</td>
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
        $('#campaigns').select2({
            placeholder: "{{__('adnetwork.campaign')}}",
            language: {
                searching: function() {
                    return "{{__('adnetwork.searching')}}";
                }
            },

            ajax: {
                url: "/api/select/campaigns",
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
        $('#fb_pages').select2({
            placeholder: "{{__('adnetwork.user_email_or_name')}}",
            language: {
                searching: function() {
                    return "{{__('adnetwork.searching')}}";
                }
            },

            ajax: {
                url: "/api/select/fb/users",
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
