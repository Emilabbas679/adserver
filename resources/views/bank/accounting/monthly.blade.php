@extends('layouts.app')
@section('title', __('adnetwork.bank_account_monthly'))
@section('content')
    <div class="content-inner">
        <div class="breadcrumb">
            <ul>
                <li><a href="{{route('dashboard', app()->getLocale())}}">Smartbee</a></li>
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
                                <div class="form-select">
                                    <select class="select-ns" name="account_no" data-placeholder="{{__('adnetwork.account_no')}}" id="account_no" >
                                        <option value="all" {{selected($account_no, 'all')}}>{{__('adnetwork.all')}}</option>
                                        @foreach($accounts as $a)
                                            <option value="{{$a['account_no']}}" {{selected($a['account_no'], $account_no)}}>{{$a['account_no']}}  {{$a['account_owner']}}</option>
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
                <div class="a-block-head">{{__('adnetwork.bank_account_transactions')}}
                    <a href="{{route('bank.accounting.create', ['lang' => app()->getLocale(), 'type'=>'credit' ])}}" class="a-button b-gr f-right with-icon add b-small ml-15">{{__('adnetwork.create_credit')}}</a>
                    <a href="{{route('bank.accounting.create', ['lang' => app()->getLocale(), 'type'=>'debit' ])}}" class="a-button b-gr f-right with-icon add b-small ml-15">{{__('adnetwork.create_debit')}}</a>

                </div>
                <div class="a-block-body">
                    <?php $balance = 0; ?>

                    @if(count($items)>0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>{{__('adnetwork.date')}}</th>
                                    <th>{{__('adnetwork.debit')}}</th>
                                    <th>{{__('adnetwork.credit')}}</th>
                                    <th>{{__('adnetwork.balance')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($items as $key => $item)
                                    <tr>
                                        <td>{{$item['month']}}</td>
                                        <td>{{number_format($item['debit'],2)}}</td>
                                        <td>{{number_format($item['credit'],2)}}</td>
                                        <td>{{number_format($item['balance'],2)}}</td>

                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td></td>
                                    <td>{{number_format(array_sum(array_column($items, 'debit')),2)}}</td>
                                    <td>{{number_format(array_sum(array_column($items, 'credit')),2)}}</td>
                                    <td>{{number_format((array_sum(array_column($items, 'debit'))-array_sum(array_column($items, 'credit'))),2)}}</td>
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
