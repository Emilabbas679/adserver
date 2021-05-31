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
                        {!! $chart->container() !!}
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

    @endsection
