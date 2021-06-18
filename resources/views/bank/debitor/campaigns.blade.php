@extends('layouts.app')
@section('title', __('adnetwork.campaign_finance'))
@section('content')
    <div class="content-inner">
        <div class="breadcrumb">
            <ul>
                <li><a href="{{route('dashboard', app()->getLocale())}}">Smartbee</a></li>
                <li><span>{{__('adnetwork.campaign_finance')}}</span></li>
            </ul>
        </div>
        <!-- Cards start -->

    @include('flash-message')
    <!-- Cards end -->

        <div class="a-block mb-20">
            <div class="a-block-head">{{__('adnetwork.search')}}</div>
            <div class="a-block-body">
                <form method="get">
                    <div class="form-group">
                        <div class="cols w-mob">


                            <div class="col-item col-d">
                                <div class="form-select">
                                    <select name="campaign_id" id="campaign_id" style="width: 100%"  data-live-search="true">
                                        @if(count($campaign)>0)
                                            <option value="{{$campaign['campaign_id']}}" selected>{{$campaign['name']}}</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-item col-d">
                                <div class="form-select">
                                    <select name="agency_id" id="agency_id" style="width: 100%"  data-live-search="true">
                                        <option value="all" selected>{{__('adnetwork.all')}}</option>
                                        <option value="0" @if($request->has("agency_id") and $request->agency_id == "0") selected @endif>{{__('adnetwork.no_agency')}}</option>
                                        @foreach($agencies as $a)
                                            <option value="{{$a['agency_id']}}" {{selected_exist($request,'agency_id', $a['agency_id'])}}>{{$a['agency_name']}}</option>
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
                            <div class="tb-item col-item"><button type="submit" class="a-button b-orange">{{__('adnetwork.search')}}</button></div>
                        </div>
                    </div>

                </form>
            </div>
        </div>

        <div class="cols">
            <div class="a-block">
                <div class="a-block-head">{{__('adnetwork.campaign_finance')}}</div>
                <div class="a-block-body">
                    @if(count($items)>0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>

                                <tr>
                                    <th>{{__('adnetwork.agency')}}</th>
                                    <th>{{__('adnetwork.campaign')}}</th>
                                    <th>{{__('adnetwork.tools')}}</th>
                                    <th>{{__('adnetwork.email')}}</th>
                                    <th>{{__('adnetwork.amount')}}</th>
                                    <th>{{__('adnetwork.charged_amount')}}</th>
                                    <th>{{__('adnetwork.chargeable_amount')}}</th>
                                    <th>{{__('adnetwork.intime')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($items as $item)
                                    <tr>
                                        <td>{{$item['agency_name']}}</td>
                                        <td>{{$item['campaign_name']}}</td>
                                        <td>
                                            <div class="tools"></div>
                                            <div class="tools-list">
                                                <ul>
                                                    <li class="edit"><a class="dropdown-item" target="_blank" href="{{route('campaign.edit', ['lang'=> app()->getLocale(), 'id' => $item['campaign_id']])}}">{{__('adnetwork.edit')}}</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td>{{$item['email']}}</td>
                                        <td>{{$item['amount']}}</td>
                                        <td>{{$item['charged_amount']}}</td>
                                        <td>{{$item['chargeable_amount']}}</td>

                                        <td>{{date('d-m-Y', strtotime($item['intime']))}}</td>
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

        $("#agency_id").select2({
            placeholder: "{{__('adnetwork.all')}}",

        })
        $('#campaign_id').select2({
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
