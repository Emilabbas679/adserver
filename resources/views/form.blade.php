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
            $('#users').select2({
                placeholder: "{{__('adnetwork.user_email_or_name')}}",
                language: {
                    searching: function() {
                        return "{{__('adnetwork.searching')}}";
                    }
                },
                ajax: {
                    url: "/api/select/users",
                    data: function(params) {
                        var query = {
                            search: params.term,
                            page: params.page || 1
                        }
                        return query;
                    },
                    delay: 600,
                    cache: true
                }
            });

            $('#agencies').select2({
                placeholder: "{{__('adnetwork.agency')}}",
                language: {
                    searching: function() {
                        return "{{__('adnetwork.searching')}}";
                    }
                },
                ajax: {
                    url: "/api/select/agencies",
                    data: function(params) {
                        var query = {
                            search: params.term,
                            page: params.page || 1
                        }
                        return query;
                    },
                    delay: 600,
                    cache: true
                }
            });
        });
    </script>
@endsection
