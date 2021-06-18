@extends('layouts.app')
@section('title', __('adnetwork.debitors'))
@section('content')
    <div class="content-inner">
        <div class="breadcrumb">
            <ul>
                <li><a href="{{route('dashboard', app()->getLocale())}}">Smartbee</a></li>
                <li><a href="{{route('debitor.campaigns', app()->getLocale())}}">{{__('adnetwork.campaign_finance')}}</a></li>
                <li><span>{{__('adnetwork.debitors')}}</span></li>
            </ul>
        </div>

        @include('partials.cards')


        <div class="a-block a-center">
            <div class="a-block-head">
                {{__('adnetwork.debitors')}}
            </div>
            <div class="a-block-body">
                <form action="{{route('debitor.financeCreate', ['lang' => app()->getLocale(),'campaign_id' => $campaign_id, 'agency_id' => $agency_id])}}" method="post">
                    @csrf
                    @include('flash-message')

                    <div class="table-responsive">
                        <table class="table dbt">
                            <thead>
                            <tr>
                                <th>{{__('adnetwork.campaign_name')}}</th>
                                <th>{{__('adnetwork.amount')}}</th>
                                <th class="dbt-200">{{__('adnetwork.charged_amount')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td style="font-weight:500;">{{$item['campaign_name']}}</td>
                                    <td>{{$item['amount']}}</td>
                                    <td>
                                        <div class="form-input">
                                            <input value='' name="campaigns[{{$item['campaign_id']}}]" type="text" id="campaigns[{{$item['campaign_id']}}]">
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>




                    <div class="t-center">
                        <button class="a-button b-green" type="submit">{{__('adnetwork.submit')}}</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection

@section('css')
    <style>
        .dbt {margin-bottom:15px;}
        .dbt .dbt-200 {width:200px; min-width:100px;}
    </style>
@endsection

@section('js')


@endsection
