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

                    <div class="form-group">
                        <label class="form-label" for="agency_id">{{__('adnetwork.agency_id')}}</label>
                        <div class="form-select">
                            <select class="select-ns" style="width: 100%" name="agency_id" data-placeholder="{{__('adnetwork.agency_id')}}" id="agency_id">

                            </select>
                            @error('agency_id')
                            <div class="notification-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

 
					

{{--                    <div class="form-group">--}}
{{--                        <label class="form-label" for="start_date"> {{__('adnetwork.start_date')}}</label>--}}
{{--                        <div class="form-input">--}}
{{--                            <input id="start_date" value='{{'01'.date('.m.Y')}}' name="start_date" id="start_date" type="text" data-toggle="datepicker" >--}}
{{--                            <i></i>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="form-group">--}}
{{--                        <label class="form-label" for="end_date"> {{__('adnetwork.end_date')}}</label>--}}
{{--                        <div class="form-input">--}}
{{--                            <input id="end_date" value='{{date('d.m.Y')}}' name="end_date" type="text" id="end_date" data-toggle="datepicker">--}}
{{--                            <i></i>--}}
{{--                        </div>--}}
{{--                    </div>--}}

                    <div id="debitor_area">

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
    <script>
        function debitorAjax(page, agency, start, end){
            $.ajax({
                type:"POST",
                data: { 'page' : page,
                    'agency_id': agency,
                    'start_date': start,
                    'end_date': end,
                    "_token": "{{ csrf_token() }}",
                },
                url:'/az/debitor/get/finance/agencies',
                success:function(response){
                    $("#debitor_area").html(response)
                    console.log(response)
                }
            });
        }

        $(document).ready(function(){


            $('#agency_id').select2({
                placeholder: "{{__('adnetwork.entity_id')}}",
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

            $("#agency_id").change(function (){
                let agency_id = $(this).val();
                let end_date = $('#end_date').val();
                let start = $('#start_date').val();
                debitorAjax(1, agency_id, start, end_date)
            })

            // $("#start_date").change(function (){
            //     let agency_id = $("#agency_id").val();
            //     let end_date = $('#end_date').val();
            //     let start = $('#start_date').val();
            //     debitorAjax(1, agency_id, start, end_date)
            // })
            //
            // $("#end_date").change(function (){
            //     let agency_id = $("#agency_id").val();
            //     let end_date = $('#end_date').val();
            //     let start = $('#start_date').val();
            //     debitorAjax(1, agency_id, start, end_date)
            // })

        });


    </script>

{{--    <script type="text/javascript" src="/js/datepicker.min.js"></script>--}}

{{--    <script type="text/javascript">--}}
{{--        $(document).ready(function(){--}}
{{--            $('[data-toggle="datepicker"]').datepicker({--}}
{{--                autoHide: true,--}}
{{--                autoPick: true,--}}
{{--                format: 'dd.mm.yyyy'--}}
{{--            });--}}

{{--            $('.bs-timepicker').timepicker();--}}

{{--            let mySelect = new vanillaSelectBox(".b-select",{--}}
{{--                placeHolder: "Seçim edin",--}}
{{--                translations: {--}}
{{--                    "items": "seçilən"--}}
{{--                }--}}
{{--            });--}}
{{--            let mySelect2 = new vanillaSelectBox(".a-select",{--}}
{{--                placeHolder: "Seçim edin",--}}
{{--                translations: {--}}
{{--                    "items": "seçilən"--}}
{{--                }--}}
{{--            });--}}
{{--            let mySelect3 = new vanillaSelectBox(".c-select",{--}}
{{--                placeHolder: "Seçim edin",--}}
{{--                translations: {--}}
{{--                    "items": "seçilən"--}}
{{--                }--}}
{{--            });--}}
{{--            let mySelect4 = new vanillaSelectBox(".d-select",{--}}
{{--                placeHolder: "Seçim edin",--}}
{{--                translations: {--}}
{{--                    "items": "seçilən"--}}
{{--                }--}}
{{--            });--}}
{{--            let mySelect5 = new vanillaSelectBox(".e-select",{--}}
{{--                placeHolder: "Seçim edin",--}}
{{--                translations: {--}}
{{--                    "items": "seçilən"--}}
{{--                }--}}
{{--            });--}}
{{--            let mySelect6 = new vanillaSelectBox(".f-select",{--}}
{{--                placeHolder: "Seçim edin",--}}
{{--                translations: {--}}
{{--                    "items": "seçilən"--}}
{{--                }--}}
{{--            });--}}
{{--            let mySelect7 = new vanillaSelectBox(".g-select",{--}}
{{--                placeHolder: "Seçim edin",--}}
{{--                translations: {--}}
{{--                    "items": "seçilən"--}}
{{--                }--}}
{{--            });--}}
{{--            var tags = document.querySelector('.b-tag');--}}
{{--            new Tagify(tags)--}}
{{--            var tags2 = document.querySelector('.b-tag2');--}}
{{--            new Tagify(tags2)--}}
{{--        });--}}
{{--    </script>--}}

{{--    <script>--}}
{{--        $('body').on('change', '#page', function() {--}}
{{--            let page = $("#page").val();--}}
{{--            let agency_id = $("#agency_id").val();--}}
{{--            let end_date = $('#end_date').val();--}}
{{--            let start = $('#start_date').val();--}}
{{--            debitorAjax(page, agency_id, start, end_date)--}}

{{--        });--}}
{{--    </script>--}}
@endsection
