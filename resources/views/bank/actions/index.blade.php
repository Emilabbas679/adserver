@extends('layouts.app')
@section('title', __('adnetwork.bank_actions'))
@section('content')
    <div class="content-inner">
        <div class="breadcrumb">
            <ul>
                <li><a href="{{route('dashboard', app()->getLocale())}}">Smartbee</a></li>
                <li><span>{{__('adnetwork.bank_actions')}}</span></li>
            </ul>
        </div>
        <!-- Cards start -->

    @include('flash-message')
    <!-- Cards end -->

        <div class="a-block mb-20">
            <div class="a-block-head">{{__('adnetwork.search_in_actions')}}</div>
            <div class="a-block-body">
                <form method="get">
                    <div class="form-group">
                        <div class="cols">
                            <div class="col-item col-d">
                                <div class="form-input">
                                    <input id="text" type="text" name="searchQuery" @if($request->has('searchQuery')) value="{{$request->searchQuery}}" @endif placeholder="{{__('adnetwork.searchQuery')}}">
                                </div>
                            </div>


                            <div class="col-item col-d">
                                <div class="form-select">
                                    <select name="type" id="country" class="select-ns" data-placeholder="{{__('adnetwork.all')}}">
                                        <option value="all">{{__('adnetwork.all')}}</option>
                                        @foreach(bank_action_types() as $type)
                                            <option value="{{$type['id']}}" {{selected_exist($request, 'type', $type['id'])}}>{{$type['text']}}</option>
                                        @endforeach
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
                                    <th>{{__('adnetwork.id')}}</th>
                                    {{--                                    <th>{{__('adnetwork.tools')}}</th>--}}
                                    <th>{{__('adnetwork.transaction_id')}}</th>
                                    <th>{{__('adnetwork.entity_id')}}</th>
                                    <th>{{__('adnetwork.entity_name')}}</th>
                                    <th>{{__('adnetwork.entity_type')}}</th>
                                    <th>{{__('adnetwork.amount')}}</th>
                                    <th>{{__('adnetwork.description')}}</th>
                                    <th>{{__('adnetwork.intime')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($items as $item)
                                    <tr>
                                        <td>{{$item['id']}}</td>
                                        {{--                                        <td>--}}
                                        {{--                                            <div class="tools"></div>--}}
                                        {{--                                            <div class="tools-list">--}}
                                        {{--                                                <ul>--}}
                                        {{--                                                    <li class="edit"><a class="dropdown-item" href="{{route('bank.pub_wallet.transactions', ['lang' => app()->getLocale(), 'user_id' => $item['user_id']])}}">{{__('adnetwork.bank_account_transactions')}}</a></li>--}}
                                        {{--                                                </ul>--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </td>--}}
                                        <td class="t-center">{{$item['transaction_id']}}</td>
                                        <td class="t-center">{{$item['entity_id']}}</td>
                                        <td class="t-center">{{$item['entity_name']}}</td>
                                        <td class="t-center">{{$item['type']}}</td>
                                        <td class="t-center">{{number_format($item['amount'],2)}}</td>
                                        <td class="t-center">{{$item['description']}}</td>
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
                ],
                order: [[0, 'desc']]

            });
            // table.columns( [5,6,7,8,9,10,11,12,13,14,15] ).visible( false );
            // table.columns.orderable( [5,6,7,8,9,10,11,12,13,14,15] );
        });
    </script>


@endsection
