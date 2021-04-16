@extends('layouts.app')
@section('title', __('adnetwork.statistic'))
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
            <div class="a-block-head">{{__('adnetwork.search')}}</div>
            <div class="a-block-body">
                <form method="get">
                    <div class="form-group mb-0">
                        <div class="cols col-table">
                            <div class="tb-item col-item col-b">
                                <div class="form-select">
                                    <select name="stats_type" id="country" class="select-ns" data-placeholder="{{__('placeholders.all_statuses')}}">
                                        <option value="get_spent_ad" {{selected_exist($request, 'stats_type', 'get_spent_ad')}}>{{__('adnetwork.ads_costs')}}</option>
                                        <option value="get_spent_site" {{selected_exist($request, 'stats_type', 'get_spent_site')}}>{{__('adnetwork.websites')}}</option>
                                        <option value="get_revenue_url" {{selected_exist($request, 'stats_type', 'get_revenue_url')}}>{{__('adnetwork.page_url')}}</option>
                                        <option value="get_spent_daily" {{selected_exist($request, 'stats_type', 'get_spent_daily')}}>{{__('adnetwork.ads_cost_daily')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="tb-item col-item col-b">
                                <div class="form-input f-calendar">
                                    <input id="text" type="text" name="start_date" @if(isset($request) and $request->has('start_date')) value="{{$request->start_date}}" @else value="01.{{date('m.Y')}}" @endif data-toggle="datepicker">
                                    <i></i>
                                </div>
                            </div>
                            <div class="tb-item col-item col-b">
                                <div class="form-input f-calendar">
                                    <input id="text" type="text" name="end_date" data-toggle="datepicker2" @if(isset($request) and $request->has('end_date')) value="{{$request->end_date}}" @else value="{{date('d.m.Y')}}" @endif>
                                    <i></i>
                                </div>
                            </div>
                            <div class="tb-item col-item"><button type="submit" class="a-button b-orange">{{__('adnetwork.search')}}</button></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="a-block">
            <div class="a-block-head">{{__('adnetwork.statistic')}}</div>
            <div class="a-block-body">
                @include('partials.statistic_table')
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
                pageLength: 15,
                lengthChange: false,
                paging: true,
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
            format: 'dd.mm.yyyy',
            endDate: 'last'
        });

        $('[data-toggle="datepicker2"]').datepicker({
            autoHide: true,
            autoPick: true,
            format: 'dd.mm.yyyy',
            endDate: 'last'
        });
    </script>


@endsection
