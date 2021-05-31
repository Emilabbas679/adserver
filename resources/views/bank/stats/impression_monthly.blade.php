@extends('layouts.app')
@section('title', __('adnetwork.impression_stats_monthly'))
@section('content')
    <div class="content-inner">
        <div class="breadcrumb">
            <ul>
                <li><a href="{{route('dashboard', app()->getLocale())}}">Smartbee</a></li>
                <li><span>{{__('adnetwork.impression_stats_monthly')}}</span></li>
            </ul>
        </div>
        <!-- Cards start -->
    @include('flash-message')
    <!-- Cards end -->
        <div class="cols">
            <div class="a-block">
                <div class="a-block-head">{{__('adnetwork.impression_stats_monthly')}}</div>
                <div class="a-block-body">
                    <?php $balance = 0; ?>

                    @if(count($items)>0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>{{__('adnetwork.month')}}</th>
                                    <th>{{__('adnetwork.impression')}}</th>
                                    <th>{{__('adnetwork.unique_impression')}}</th>
                                    <th>{{__('adnetwork.click')}}</th>
                                    <th>{{__('adnetwork.unique_click')}}</th>
                                    <th>{{__('adnetwork.site_impression')}}</th>
                                    <th>{{__('adnetwork.site_click')}}</th>
                                    <th>{{__('adnetwork.reach')}}</th>
                                    <th>{{__('adnetwork.error')}}</th>
                                    <th>{{__('adnetwork.video_start')}}</th>
                                    <th>{{__('adnetwork.firstquartile')}}</th>
                                    <th>{{__('adnetwork.midpoint')}}</th>
                                    <th>{{__('adnetwork.thirdquartile')}}</th>
                                    <th>{{__('adnetwork.complete')}}</th>
                                    <th>{{__('adnetwork.spent_amount')}}</th>
                                    <th>{{__('adnetwork.wallet_spent_amount')}}</th>
                                    <th>{{__('adnetwork.publisher_amount')}}</th>
                                    <th>{{__('adnetwork.system_amount')}}</th>
                                    <th>{{__('adnetwork.ref_user_amount')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($items as $key => $item)
                                    <tr>
                                        <td>{{$item['month']}}</td>
                                        <td>{{$item['impression']}}</td>
                                        <td>{{$item['unique_impression']}}</td>
                                        <td>{{$item['click']}}</td>
                                        <td>{{$item['unique_click']}}</td>
                                        <td>{{$item['site_impression']}}</td>
                                        <td>{{$item['site_click']}}</td>
                                        <td>{{$item['reach']}}</td>
                                        <td>{{$item['error']}}</td>
                                        <td>{{$item['video_start']}}</td>
                                        <td>{{$item['firstQuartile']}}</td>
                                        <td>{{$item['midpoint']}}</td>
                                        <td>{{$item['thirdQuartile']}}</td>
                                        <td>{{$item['complete']}}</td>
                                        <td>{{number_format($item['spent_amount'],2)}}</td>
                                        <td>{{number_format($item['wallet_spent_amount'],2)}}</td>
                                        <td>{{number_format($item['publisher_amount'],2)}}</td>
                                        <td>{{number_format($item['system_amount'],2)}}</td>
                                        <td>{{number_format($item['ref_user_amount'],2)}}</td>
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
