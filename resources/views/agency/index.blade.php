@extends('layouts.app')
@section('title', __('adnetwork.agencies'))
@section('content')
    <div class="content-inner">
        <div class="breadcrumb">
            <ul>
                <li><a href="{{route('home', app()->getLocale())}}">Smartbee</a></li>
                <li><span>{{__('adnetwork.agencies')}}</span></li>
            </ul>
        </div>

        @include('partials.cards')
        @include('flash-message')
        <div class="a-block mb-20">
            <div class="a-block-head">{{__('agency_name.search_in_agencies')}}</div>
            <div class="a-block-body">
                <form  method="get">
                    <div class="form-group mb-0">
                        <div class="cols col-table">
                            <div class="tb-item col-item col-b">
                                <div class="form-input">
                                    <input id="text" type="text" name="agency_name" @if($request->has('agency_name')) value="{{$request->agency_name}}" @endif placeholder="{{__('adnetwork.agency_name')}}">
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
            <div class="a-block-head">{{__('adnetwork.agencies')}}
                <a href="{{route('agency.create', app()->getLocale())}}" class="a-button b-gr f-right with-icon add b-small">{{__('adnetwork.add_agency')}}</a>
            </div>
            <div class="a-block-body">
                @if(count($items)>0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>{{__('adnetwork.agency_id')}}</th>
                                <th>{{__('adnetwork.tools')}}</th>
                                <th>{{__('adnetwork.agency_name')}}</th>
                                <th>{{__('adnetwork.agency_address')}}</th>
                                <th>{{__('adnetwork.voen')}}</th>
                                <th>{{__('adnetwork.intime')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>{{$item['agency_id']}}</td>
                                    <td>
                                        <div class="tools"></div>
                                        <div class="tools-list">
                                            <ul>
                                                <li class="edit"><a class="dropdown-item" href="{{route('agency.edit', ['lang'=> app()->getLocale(), 'id' => $item['agency_id']])}}">{{__('adnetwork.edit')}}</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td>{{$item['agency_name']}}</td>
                                    <td>{{$item['agency_address']}}</td>
                                    <td>{{$item['voen']}}</td>
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
@endsection
