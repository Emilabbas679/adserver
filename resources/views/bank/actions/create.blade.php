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
            function select2_function(type){
                let selectType = 'users';
                if (type == 'articles_sites') {
                    selectType = 'sites';
                }
                else if(type == 'user'){
                    selectType = 'users';
                }
                else if(type == 'user_agency'){
                    selectType = 'agencies';
                }
                else if(type == 'pub_wallet'){
                    selectType = 'users';
                }
                else if(type == 'finance_cost'){
                    selectType = 'finance/cost';
                }

                $('#entity_id').select2({
                    placeholder: "{{__('adnetwork.entity_id')}}",
                    language: {
                        searching: function() {
                            return "{{__('adnetwork.searching')}}";
                        }
                    },
                    ajax: {
                        url: "/api/select/"+selectType,
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

            }

            let type = $("#entity_type").val();
            select2_function(type);

            $("#entity_type").change(function (){
                let entity_type = $(this).val();
                select2_function(entity_type);
            });






        });
    </script>
@endsection
