@extends('layouts.app')
@section('title', env('APP_NAME'))
@section('content')
    <div class="content-inner homepage">
        <div class="breadcrumb">
            <ul>
                <li><a href="{{route('home')}}">Smartbee</a></li>
                <li><span>İdarə paneli</span></li>
            </ul>
        </div>
        <!-- Cards start -->
        @include('partials.cards')
        @include('flash-message')
        <!-- Cards end -->
        <div class="cols">
            <div class="col-item col-a">
                <div class="a-block">
                    <div class="a-block-head">Reklam elanları</div>
                    <div class="a-block-body">
                        <div id="chart"></div>

{{--                        {!! $chart->container() !!}--}}
                    </div>
                </div>
            </div>
            <div class="col-item col-a">
                <div class="a-block">
                    <div class="a-block-head">Form elements</div>
                    <div class="a-block-body">
                        {!! $chart_pie->container() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

    <script src="{{ LarapexChart::cdn() }}"></script>

    <!-- Or use the cdn directly -->

    <!-- <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> -->

    <!-- Or use the local library as asset the package already provides a publication with this file *see below -->

    {{--<!-- <script src="{{ asset('vendor/larapex-charts/apexchart.js') }}"></script> -->--}}

    {{ $chart->script() }}
    {{ $chart_pie->script() }}


    <script src="https://www.gstatic.com/charts/loader.js"></script>

    <script>
        google.charts.load('current', {
            callback: function () {
                var data = new google.visualization.DataTable({
                    cols: [
                        {label: 'x', type: 'string'},
                        {label: 'Impression', type: 'number'},
                        {label: 'Click', type: 'number'},
                        {label: 'Spent', type: 'number'}
                    ],
                    rows: [
                        @for($i = 1; $i<=(int) date('m'); $i++)

                            {c:[{v: "{{__('adnetwork.month_'.$i)}}"}, {v: Math.random(1000000, 9999999)*1000000000}, {v: Math.random(0.0001, 0.9)*1000}, {v:  Math.random(10,1000)}]} @if($i != (int) date('m')), @endif


                        @endfor

                    ]
                });

                var container = document.getElementById('chart');
                var chart = new google.visualization.LineChart(container);

                chart.draw(data, {
                    colors: ['#fd7241', '#0054e7', '#2bf500'],
                    is3D: true,


                //     width: '100%',
                    height: 400,
                    series: {
                        1: {
                            targetAxisIndex: 1,
                        },

                        2: {
                            targetAxisIndex: 2,
                        },

                        3: {
                            targetAxisIndex: 3,
                        },
                    },
                //     theme: 'material',
                     vAxis: {textPosition:'none'}
                });
            },
            packages: ['corechart']
        });
    </script>

    @endsection
