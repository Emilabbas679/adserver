@extends('layouts.app')
@section('title', $item['name'])
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
            <div class="a-block-head">{{$item['name']}}</div>
            <div class="a-block-body">
                <form action="{{route('campaign.edit', ['lang' => app()->getLocale(), 'id'=>$item['campaign_id']])}}" method="post">
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
@section('js')
    <script>
        $(document).ready(function(){
            $('#users').select2({
                placeholder: "{{__('placeholders.username')}}",
                language: {
                    searching: function() {
                        return "{{__('placeholders.searching')}}";
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
                placeholder: "{{__('placeholders.agency')}}",
                language: {
                    searching: function() {
                        return "{{__('placeholders.searching')}}";
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
