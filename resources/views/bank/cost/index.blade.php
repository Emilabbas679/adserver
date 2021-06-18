@extends('layouts.app')
@section('title', __('adnetwork.costs'))
@section('content')
    <div class="content-inner">
        <div class="breadcrumb">
            <ul>
                <li><a href="{{route('dashboard', app()->getLocale())}}">Smartbee</a></li>
                <li><span>{{__('adnetwork.costs')}}</span></li>
            </ul>
        </div>
        <!-- Cards start -->

    @include('flash-message')
    <!-- Cards end -->

        <div class="a-block mb-20">
            <div class="a-block-head">{{__('adnetwork.search_in_costs')}}</div>
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
                                    <select class="select-ns" name="category_id" data-placeholder="{{__('adnetwork.category_id')}}" id="account_no" >
                                        <option value="all"  {{selected_exist($request, 'category_id', 'all')}}>{{__('adnetwork.all')}}</option>
                                        @foreach($categories as $a)
                                            <option value="{{$a['id']}}" {{selected_exist($request, 'category_id', $a['id'])}}>{{$a['name']}}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <div class="cols col-table">
                            <div class="tb-item col-item col-a">
                                <div class="form-input f-calendar">
                                    <input id="start_date" value='{{$start_date}}' name="start_date" type="text" data-toggle="datepicker" >
                                    <i></i>
                                </div>
                            </div>
                            <div class="tb-item col-a col-item" >
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



        <div class="cols">
            <div class="a-block">
                <div class="a-block-head">{{__('adnetwork.bank_account_transactions')}}
                    <a href="{{route('bank.cost.create', ['lang' => app()->getLocale() ])}}" class="a-button b-gr f-right with-icon add b-small ml-15">{{__('adnetwork.add_cost')}}</a>

                </div>
                    <div class="a-block-body">
                        @if(count($items)>0)
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>

                                    <tr>
                                        <th>{{__('adnetwork.id')}}</th>
                                        <th>{{__('adnetwork.amount')}}</th>
                                        <th>{{__('adnetwork.cost_time')}}</th>
                                        <th>{{__('adnetwork.description')}}</th>
                                        <th>{{__('adnetwork.cost_category_name')}}</th>
                                        <th>{{__('adnetwork.intime')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($items as $item)
                                        <tr>
                                            <td>{{$item['id']}}</td>
                                            <td>{{number_format($item['amount'],2)}}</td>
                                            <td>{{date('d-m-Y', strtotime($item['cost_time']))}}</td>
                                            <td>{!! $item['description'] !!}</td>
                                            <td>{{$item['cost_category_name']}}</td>
                                            <td>{{date('d-m-Y', strtotime($item['intime']))}}</td>

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
