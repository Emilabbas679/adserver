@extends('layouts.app')
@section('title', __('adnetwork.bank_accounts'))
@section('content')
    <div class="content-inner">
        <div class="breadcrumb">
            <ul>
                <li><a href="{{route('dashboard', app()->getLocale())}}">Smartbee</a></li>
                <li><span>İdarə paneli</span></li>
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
                                <div class="form-input">
                                    <input id="text" type="text" name="searchQuery" @if($request->has('searchQuery')) value="{{$request->searchQuery}}" @endif placeholder="{{__('adnetwork.search_in_transactions')}}">
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
                <div class="a-block-head">{{__('adnetwork.bank_accounts')}}
                    <a href="{{route('bank.account_number.create', app()->getLocale())}}" class="a-button b-gr f-right with-icon add b-small">{{__('adnetwork.create')}}</a>
                </div>
                    <div class="a-block-body">
                        @if(count($items)>0)
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>

                                    <tr>
                                        <th>{{__('adnetwork.id')}}</th>
                                        <th>{{__('adnetwork.tools')}}</th>
                                        <th>{{__('adnetwork.account_no')}}</th>
                                        <th>{{__('adnetwork.account_owner')}}</th>
                                        <th>{{__('adnetwork.customer_code')}}</th>
                                        <th>{{__('adnetwork.status_id')}}</th>
                                        <th>{{__('adnetwork.bank')}}</th>
                                        <th>{{__('adnetwork.voen')}}</th>
                                        <th>{{__('adnetwork.code')}}</th>
                                        <th>{{__('adnetwork.correspondent')}}</th>
                                        <th>{{__('adnetwork.swift')}}</th>
                                        <th>{{__('adnetwork.iban')}}</th>
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
                                                        <li class="edit"><a class="dropdown-item" href="{{route('bank.account_number.edit', ['lang'=>app()->getLocale(), 'id'=>$item['id']])}}" target="_blank">{{__('adnetwork.edit')}}</a></li>
                                                        @if($item['status_id'] != 11)
                                                            <li class="activate"><a class="dropdown-item" href="{{route('bank.accounts.status', ['lang' => app()->getLocale(), 'id' => $item['id'], 'status_id' => 11])}}">{{__('adnetwork.active')}}</a></li>
                                                        @elseif($item['status_id'] != 27)
                                                            <li class="delete"><a class="dropdown-item" href="{{route('bank.accounts.status', ['lang' => app()->getLocale(), 'id' => $item['id'], 'status_id' => 27])}}">{{__('adnetwork.delete')}}</a></li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </td>
                                            <td>{{$item['account_no']}}</td>
                                            <td>{{$item['account_owner']}}</td>
                                            <td>{{$item['customer_code']}}</td>
                                            <td class="t-center">
                                                <span data-id="{{$item['status_id']}}" class="badge @if($item['status_id'] == 11) badge-success @elseif($item['status_id'] == 12) badge-info @elseif($item['status_id'] == 17) badge-warning @elseif($item['status_id'] == 10) badge-danger @elseif($item['status_id'] == 27) badge-danger @elseif($item['status_id'] == 40) badge-warning  @endif ">
                                                    @if($item['status_id'] == 11)      {{__('adnetwork.ad_static_status_11')}}
                                                    @elseif($item['status_id'] == 12)  {{__('adnetwork.ad_static_status_12')}}
                                                    @elseif($item['status_id'] == 17)  {{__('adnetwork.ad_static_status_17')}}
                                                    @elseif($item['status_id'] == 10)  {{__('adnetwork.ad_static_status_10')}}
                                                    @elseif($item['status_id'] == 27)  {{__('adnetwork.ad_static_status_27')}}
                                                    @elseif($item['status_id'] == 40)  {{__('adnetwork.ad_static_status_40')}}
                                                    @endif
									            </span>
                                            </td>
                                            <td>{{$item['bank']}}</td>
                                            <td>{{$item['voen']}}</td>
                                            <td>{{$item['code']}}</td>
                                            <td>{{$item['correspondent']}}</td>
                                            <td>{{$item['swift']}}</td>
                                            <td>{{$item['iban']}}</td>
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
