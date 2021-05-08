@extends('layouts.app')
@section('title', $item['bank'])
@section('content')
    <div class="content-inner">
        <div class="breadcrumb">
            <ul>
                <li><a href="{{route('home', app()->getLocale())}}">Smartbee</a></li>
                <li><span>İdarə paneli</span></li>
            </ul>
        </div>

        @include('partials.cards')


        <div class="a-block a-center">
            <div class="a-block-head">{{ $item['bank'] }}</div>
            <div class="a-block-body">
                <form action="{{route('bank.account_number.edit', ['lang' => app()->getLocale(), 'id'=>$item['id']])}}" method="post">
                    @csrf
                    @include('flash-message')
                    @include('partials.form')
                    <div class="t-center">
                        <button class="a-button b-green" type="submit">{{__('admin.submit')}}</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection

