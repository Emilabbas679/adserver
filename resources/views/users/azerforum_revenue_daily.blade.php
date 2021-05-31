@extends('layouts.app')
@section('title', $user['full_name'])
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
            <div class="a-block-head">{{__('agency_name.search_in_stats')}}</div>
            <div class="a-block-body">
                <form method="get">

                    <div class="form-group mb-0">
                        <div class="cols col-table">
                            <div class="tb-item col-item col-a" style="width: 25% !important;">
                                <div class="form-input f-calendar">
                                    <input id="start_date" value='{{$start_date}}' name="start_date" type="text" data-toggle="datepicker" >
                                    <i></i>
                                </div>
                            </div>
                            <div class="tb-item col-a col-item" style="width: 25% !important;">
                                <div class="form-input f-calendar">
                                    <input id="end_date" value='{{$end_date}}' name="end_date" type="text" data-toggle="datepicker">
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
            <div class="a-block-head">{{ $user['full_name']}}
            </div>
            <div class="a-block-body">
                @if(count($items)>0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>{{__('adnetwork.date')}}</th>
                                <th>{{__('adnetwork.click')}}</th>
                                <th>{{__('adnetwork.impression')}}</th>
                                <th>{{__('adnetwork.ecpm')}}</th>
                                <th>{{__('adnetwork.amount')}}</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $item)

                                <tr>
                                    <td>{{date('d.m.Y',strtotime($item['intime']))}} </td>
                                    <td>{{number_format($item['site_click'])}}</td>
                                    <td>{{number_format($item['site_impression'])}}</td>
                                    <td>@if($item['site_impression'] > 0 ){{ number_format(($item['publisher_amount'] / $item['site_impression'] * 1000),2) }}@else - @endif</td>
                                    <td>{{number_format($item['publisher_amount'], 4)}} ₼ </td>
                                </tr>

                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td>{{__("adnetwork.sum")}}</td>
                                <td>{{array_sum(array_column($items, 'site_click'))}}</td>
                                <td>{{array_sum(array_column($items, 'site_impression'))}}</td>
                                <td>
                                    @if(array_sum(array_column($items, 'site_impression')) > 0 )
                                        {{ number_format(( array_sum(array_column($items, 'publisher_amount'))  / array_sum(array_column($items, 'site_impression')) * 1000),2) }}
                                    @else
                                        -
                                    @endif


                                </td>
                                {{--                            <td>@if(array_sum(array_column($items, 'site_impression')) > 0 ) {{ number_format((array_sum(array_column($items, 'publisher_amount')) / (array_sum(array_column($items, 'site_impression'))) * 1000),2) }} @else - @endif</td>--}}
                                {{--                            <td>@if(array_sum(array_column($items, 'site_click')) > 0 ) {{ number_format((array_sum(array_column($items, 'publisher_amount')) / (array_sum(array_column($items, 'site_click'))) * 1000),2) }} @else - @endif</td>--}}
                                {{--                            <td>@if(array_sum(array_column($items, 'site_impression')) > 0 ) {{ number_format((array_sum(array_column($items, 'site_click')) / (array_sum(array_column($items, 'site_impression'))) * 1000),2) }} @else - @endif</td>--}}
                                <td>{{array_sum(array_column($items, 'publisher_amount'))}}</td>
                            </tr>
                            </tfoot>

                        </table>
                    </div>
                @else
                    <div class="alert alert-warning alert-styled-right alert-dismissible">
                        {{__('adnetwork.not_found')}}
                    </div>
                @endif


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

    <script type="text/javascript" src="/js/datepicker.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="datepicker"]').datepicker({
                autoHide: true,
                autoPick: true,
                format: 'dd.mm.yyyy'
            });

            $('.bs-timepicker').timepicker();

            let mySelect = new vanillaSelectBox(".b-select",{
                placeHolder: "Seçim edin",
                translations: {
                    "items": "seçilən"
                }
            });
            let mySelect2 = new vanillaSelectBox(".a-select",{
                placeHolder: "Seçim edin",
                translations: {
                    "items": "seçilən"
                }
            });
            let mySelect3 = new vanillaSelectBox(".c-select",{
                placeHolder: "Seçim edin",
                translations: {
                    "items": "seçilən"
                }
            });
            let mySelect4 = new vanillaSelectBox(".d-select",{
                placeHolder: "Seçim edin",
                translations: {
                    "items": "seçilən"
                }
            });
            let mySelect5 = new vanillaSelectBox(".e-select",{
                placeHolder: "Seçim edin",
                translations: {
                    "items": "seçilən"
                }
            });
            let mySelect6 = new vanillaSelectBox(".f-select",{
                placeHolder: "Seçim edin",
                translations: {
                    "items": "seçilən"
                }
            });
            let mySelect7 = new vanillaSelectBox(".g-select",{
                placeHolder: "Seçim edin",
                translations: {
                    "items": "seçilən"
                }
            });
            var tags = document.querySelector('.b-tag');
            new Tagify(tags)
            var tags2 = document.querySelector('.b-tag2');
            new Tagify(tags2)
        });
    </script>



@endsection
