@extends('layouts.app')
@section('title', $item['full_name'])
@section('content')
    <div class="content-inner">
        <div class="breadcrumb">
            <ul>
                <li><a href="{{route('home', app()->getLocale())}}">Smartbee</a></li>
                <li><span>İdarə paneli</span></li>
            </ul>
        </div>

        @include('partials.cards')
        @include('flash-message')

        <div class="a-block a-center">
            <div class="a-block-head">{{$item['full_name']}}</div>
            <div class="a-block-body">
                <form action="{{route('profile_settings', ['lang' => app()->getLocale(), 'id'=>$item['user_id']])}}" method="post">
                    @csrf
                    @include('partials.form')
                    <div class="t-center">
						<button class="a-button b-green" type="submit">{{__('admin.submit')}}</button>
					</div>
                </form>
            </div>
        </div>

    </div>
@endsection
