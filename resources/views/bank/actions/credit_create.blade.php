@extends('layouts.app')
@section('title', $page['title'])
@section('content')
    <div class="content-inner">
        <div class="breadcrumb">
            <ul>
                @foreach($page['breadcrumbs'] as $p)
                    @if($p['breadcrumbs'])
                        <li><a href="{{$p['route']}}">{{$p['title']}}</a></li>
                    @else
                        <li><span>{{$p['title']}}</span></li>
                    @endif
                @endforeach

            </ul>
        </div>

        @include('partials.cards')


        <div class="a-block a-center">
            <div class="a-block-head">
                {{$page['title']}}
            </div>
            <div class="a-block-body">
                <form action="{{$page['form']['action']}}" method="{{$page['form']['method']}}">
                    @csrf
                    @include('flash-message')
                    @include('partials.form')
                    <div class="t-center">
                        <button class="a-button b-green" type="submit">{{__('adnetwork.submit')}}</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function(){
                $('#entity_id').select2({
                    placeholder: "{{__('adnetwork.entity_id')}}",
                    language: {
                        searching: function() {
                            return "{{__('adnetwork.searching')}}";
                        }
                    },
                });
            });


    </script>
@endsection
