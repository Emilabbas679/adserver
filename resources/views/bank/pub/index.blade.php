@extends('layouts.app')
@section('title', __('adnetwork.pub_all_wallet'))
@section('content')
    <div class="content-inner">
        <div class="breadcrumb">
            <ul>
                <li><a href="{{route('dashboard', app()->getLocale())}}">Smartbee</a></li>
                <li><span>{{__('adnetwork.pub_all_wallet')}}</span></li>
            </ul>
        </div>
        <!-- Cards start -->

    @include('flash-message')
    <!-- Cards end -->

        <div class="a-block mb-20">
            <div class="a-block-head">{{__('adnetwork.search_in_accounts')}}</div>
            <div class="a-block-body">
                <form method="get">
                    <div class="form-group">
                        <div class="cols">


                            <div class="col-item col-a">
                                <div class="form-select">
                                    <select name="user_id" id="users" style="width: 100%"  data-live-search="true">
                                        @if(count($user_api)>0)
                                            <option value="{{$user_api['user_id']}}" selected>{{$user_api['email']}}</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-item col-b">
                                <div class="form-select">
                                    <select name="site_id" id="site_id" style="width: 100%"  data-live-search="true">
                                        <option value="0" {{selected_exist($request,'site_id', 0)}}>{{__('adnetwork.all')}}</option>
                                        <option value="1366" {{selected_exist($request,'site_id', 1366)}}>Azerforum</option>
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
                <div class="a-block-head">{{__('adnetwork.pub_all_wallet')}}</div>
                <div class="a-block-body">
                    @if(count($items)>0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>

                                <tr>
                                    <th>{{__('adnetwork.user_email_or_name')}}</th>
                                    <th>{{__('adnetwork.tools')}}</th>
                                    <th>{{__('adnetwork.revenue_amount')}}</th>
                                    <th>{{__('adnetwork.paid_amount')}}</th>
                                    <th>{{__('adnetwork.payable_amount')}}</th>
                                    <th>{{__('adnetwork.pending_amount')}}</th>
                                    <th>{{__('adnetwork.description')}}</th>
                                    <th>{{__('adnetwork.intime')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($items as $item)
                                    <tr>
                                        <td>{{$item['email']}}</td>
                                        <td>
                                            <div class="tools"></div>
                                            <div class="tools-list">
                                                <ul>
                                                    <li class="edit"><a class="dropdown-item" href="{{route('bank.pub_wallet.transactions', ['lang' => app()->getLocale(), 'user_id' => $item['user_id']])}}">{{__('adnetwork.bank_account_transactions')}}</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td class="t-center">{{number_format($item['revenue_amount'],2)}}</td>
                                        <td class="t-center">{{number_format($item['paid_amount'],2)}}</td>
                                        <td class="t-center">{{number_format($item['payable_amount'],2)}}</td>
                                        <td class="t-center">{{number_format($item['pending_amount'],2)}}</td>
                                        <td>{{$item['description']}}</td>
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
        $("#site_id").select2({
            placeholder: "{{__('adnetwork.all')}}",

        })
    </script>
@endsection
