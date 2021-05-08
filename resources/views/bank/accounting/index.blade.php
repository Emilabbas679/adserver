@extends('layouts.app')
@section('title', __('adnetwork.bank_account_transactions'))
@section('content')
    <div class="content-inner">
        <div class="breadcrumb">
            <ul>
                <li><a href="{{route('home', app()->getLocale())}}">Smartbee</a></li>
                <li><span>{{__('adnetwork.bank_account_transactions')}}</span></li>
            </ul>
        </div>
        <!-- Cards start -->

    @include('flash-message')
    <!-- Cards end -->

        <div class="a-block mb-20">
            <div class="a-block-head">{{__('adnetwork.search_in_transactions')}}</div>
            <div class="a-block-body">
                <form method="get">
                    <div class="form-group">
                        <div class="cols">
                            <div class="col-item col-a">
                                <div class="form-input">
                                    <input id="text" type="text" name="searchQuery" @if($request->has('searchQuery')) value="{{$request->searchQuery}}" @endif placeholder="{{__('adnetwork.search_in_transactions')}}">
                                </div>
                            </div>
                            <div class="col-item col-a">
                                <div class="form-select">
                                    <select class="select-ns" name="account_no" data-placeholder="{{__('adnetwork.account_no')}}" id="account_no" >
                                        <option value="all" {{selected($account_no, 'all')}}>{{__('adnetwork.all')}}</option>
                                        @foreach($accounts as $a)
                                            <option value="{{$a['account_no']}}" {{selected($a['account_no'], $account_no)}}>{{$a['account_no']}}  {{$a['account_owner']}}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
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

                            <div class="tb-item col-item col-b">
                                <div class="form-select">
                                    <select name="amount_type" id="amount_type" class="select-ns" data-placeholder="{{__('adnetwork.all_statuses')}}">
                                        <option value="0" {{selected_exist($request, 'amount_type', '0')}}>{{__('adnetwork.all')}}</option>
                                        <option value="1" {{selected_exist($request, 'amount_type', '1')}}>{{__('adnetwork.debit')}}</option>
                                        <option value="2" {{selected_exist($request, 'amount_type', '2')}}>{{__('adnetwork.credit')}}</option>

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
                <div class="a-block-head">{{__('adnetwork.bank_account_transactions')}}
                    <a href="{{route('bank.accounting.create', ['lang' => app()->getLocale(), 'type'=>'credit' ])}}" class="a-button b-gr f-right with-icon add b-small ml-15">{{__('adnetwork.create_credit')}}</a>
                    <a href="{{route('bank.accounting.create', ['lang' => app()->getLocale(), 'type'=>'debit' ])}}" class="a-button b-gr f-right with-icon add b-small ml-15">{{__('adnetwork.create_debit')}}</a>

                </div>
                    <div class="a-block-body">
                        @if(count($items)>0)
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>

                                    <tr>
                                        <th>{{__('adnetwork.id')}}</th>
                                        <th>{{__('adnetwork.account')}}</th>
                                        <th>{{__('adnetwork.date')}}</th>
                                        <th>{{__('adnetwork.debit')}}</th>
                                        <th>{{__('adnetwork.credit')}}</th>
                                        <th>{{__('adnetwork.balance')}}</th>
                                        <th>{{__('adnetwork.description')}}</th>
                                        <th>{{__('adnetwork.intime')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($items as $item)
                                        <tr>
                                            <td>{{$item['id']}}</td>
                                            <td>{{$item['account_no']}}</td>
                                            <td>{{$item['date']}}</td>
                                            <td>{{$item['debit']}}</td>
                                            <td>{{$item['credit']}}</td>
                                            <td>{{$item['balance']}}</td>
                                            <td>{{$item['description']}}</td>
                                            <td>{{date('Y-m-d', strtotime($item['intime']))}}</td>
                                        </tr>

                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>{{number_format(array_sum(array_column($items, 'debit')),2)}}</td>
                                        <td>{{number_format(array_sum(array_column($items, 'credit')),2)}}</td>
                                        <td>{{number_format(array_sum(array_column($items, 'debit'))-array_sum(array_column($items, 'credit')),2)}}</td>
                                        <td></td>
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
                ],
                order: [[0, 'asc']]

            });

            // table.columns( [5,6,7,8,9,10,11,12,13,14,15] ).visible( false );
            // table.columns.orderable( [5,6,7,8,9,10,11,12,13,14,15] );

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
