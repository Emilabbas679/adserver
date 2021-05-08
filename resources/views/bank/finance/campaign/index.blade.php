@extends('layouts.app')
@section('title', __('titles.campaign'))
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
            <div class="a-block-head">{{__('admin.search_in_campaigns')}}</div>
            <div class="a-block-body">
                <form  method="get">
                    <div class="form-group mb-0">
                        <div class="cols col-table">
                            <div class="tb-item col-item col-b">
                                <div class="form-input">
                                    <input id="text" type="text" name="chargeable_amount" @if($request->has('chargeable_amount')) value="{{$request->chargeable_amount}}" @endif placeholder="{{__('adnetwork.chargeable_amount')}}">
                                </div>
                            </div>
                            <div class="tb-item col-item col-b">
                                <div class="form-input">
                                    <input id="text" type="text" name="charged_amount" @if($request->has('charged_amount')) value="{{$request->charged_amount}}" @endif placeholder="{{__('adnetwork.charged_amount')}}">
                                </div>
                            </div>
                            <div class="tb-item col-item col-b">
                                <div class="form-select">
                                    <select name="campaign_id" id="campaigns" style="width: 100%"  data-live-search="true">
                                        @if(count($campaign)>0)
                                            <option value="{{$campaign['campaign_id']}}" selected>{{$campaign['name']}}</option>
                                        @endif
                                    </select>
                                    {{--                                        <input id="text" type="text" placeholder="{{__('placeholders.username')}}">--}}
                                </div>
                            </div>
                            <div class="tb-item col-item">
                                <button type="submit" class="a-button b-orange">{{__('admin.search')}}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="a-block">
            <div class="a-block-head">{{__('admin.campaigns')}}

{{--                <a href="{{route('campaign.create', app()->getLocale())}}" class="a-button b-gr f-right with-icon add b-small">{{__('adnetwork.create')}}</a>--}}
            </div>
            <div class="a-block-body">
                @if(count($items)>0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>{{__('adnetwork.id')}}</th>
                                <th>{{__('adnetwork.campaign')}}</th>
                                <th>{{__('adnetwork.amount')}}</th>
                                <th>{{__('adnetwork.charged_amount')}}</th>
                                <th>{{__('adnetwork.chargeable_amount')}}</th>
                                <th>{{__('adnetwork.budget_planned')}}</th>
                                <th>{{__('adnetwork.budget_spent')}}</th>
                                <th>{{__('adnetwork.intime')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>{{$item['id']}}</td>
                                    <td>{{$item['campaign_name']}}</td>
                                    <td>@if($item['amount']) {{number_format($item['amount'], 2)}} @else 0 @endif</td>
                                    <td>@if($item['charged_amount']) {{number_format($item['charged_amount'], 2)}} @else 0 @endif</td>
                                    <td>@if($item['chargeable_amount']) {{number_format($item['chargeable_amount'], 2)}} @else 0 @endif</td>
                                    <td>@if($item['budget_planned']) {{number_format($item['budget_planned'], 2)}} @else 0 @endif</td>
                                    <td>@if($item['budget_spent']) {{number_format($item['budget_spent'], 2)}} @else 0 @endif</td>
                                    <td>{{date('Y-m-d', strtotime($item['intime']))}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-warning alert-styled-right alert-dismissible">
                        {{__('notification.empty_result')}}
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
