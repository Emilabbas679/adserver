@extends('layouts.app')
@section('title', __('adnetwork.ad_add') )
@section('content')
    <div class="content-inner">
        <div class="breadcrumb">
            <ul>
                <li><a href="{{route('home', app()->getLocale())}}">{{__('adnetwork.home')}}</a></li>
                <li><a href="{{route('advert.index', app()->getLocale())}}">{{__('adnetwork.ad_list')}}</a></li>
                <li><span>{{__('adnetwork.ad_add')}}</span></li>
            </ul>
        </div>
        @include('partials.cards')
        <div class="a-block a-center">
            <div class="a-block-head">{{__('adnetwork.ad_add')}}</div>
            <div class="a-block-body">
                <div class="form form-horizontal">
                    <form method="post" action="{{route('advert.create', ['lang' => app()->getLocale()])}}" enctype="multipart/form-data">
                        @csrf
                        @include('flash-message')
                        <div class="form-group">
                            <label class="form-label" for="campaign">{{__('adnetwork.campaign_name')}}</label>
                            <div class="form-select">
                                <select class="select-ns" name="campaign_id" id="campaign">
                                    @foreach($campaigns as $c)
                                        <option value="{{$c['campaign_id']}}" {{selected(old('campaign_id'), $c['campaign_id'])}}>{{$c['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="group">{{__('adnetwork.adset_group')}}</label>
                            <div class="form-select">
                                <select class="select-ns" name="set_id" id="group">
                                    @foreach($groups as $c)
                                        <option value="{{$c['set_id']}}" {{selected(old('set_id'), $c['set_id'])}}>{{$c['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="w-format">{{__('adnetwork.format')}}</label>
                            <div class="form-select">
                                <select class="select-ns" name="format" id="w-format">
                                    <option value="10" {{selected(old('format'), 10)}}>{{__('adnetwork.ad_static_name_10')}}</option>
                                    <option value="11" {{selected(old('format'), 11)}}>{{__('adnetwork.ad_static_name_11')}}</option>
                                    <option value="12" {{selected(old('format'), 12)}}>{{__('adnetwork.ad_static_name_12')}}</option>
                                    <option value="15" {{selected(old('format'), 15)}}>{{__('adnetwork.ad_static_name_15')}}</option>
                                    <option value="79" {{selected(old('format'),79)}}>{{__('adnetwork.ad_static_name_79')}}</option>
                                    <option value="83" {{selected(old('format'), 83)}}>{{__('adnetwork.ad_static_name_83')}}</option>
                                    <option value="260" {{selected(old('format'),260)}}>{{__('adnetwork.ad_static_name_260')}}</option>
                                    <option value="261" {{selected(old('format'), 261)}}>{{__('adnetwork.ad_static_name_261')}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" id="adJsnamelabel">{{__('adnetwork.news_title')}}</label>
                            <div class="form-input">
                                <input value='{{old('name')}}' placeholder="{{__('adnetwork.name')}}" name="name" type="text">
                                @error('name')
                                <div class="notification-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="url">{{__('adnetwork.advert_url')}}</label>
                            <div class="form-input">
                                <input id="url" value='{{old('target_url')}}' placeholder="{{__('adnetwork.advert_url')}}" name="target_url" type="text">
                                @error('target_url')
                                <div class="notification-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group d-none" id="adJsdimension_id">
                            <label class="form-label">{{__('adnetwork.size')}}</label>
                            <div class="form-select">
                                <select class="select-ns" name="dimension_id">
                                    <option value="3" {{selected(old('dimension_id'), 3)}}>728x90</option>
                                    <option value="5" {{selected(old('dimension_id'), 5)}}>320x100</option>
                                    <option value="6" {{selected(old('dimension_id'), 6)}}>300x600</option>
                                    <option value="7" {{selected(old('dimension_id'), 7)}}>300x250</option>
                                    <option value="12" {{selected(old('dimension_id'), 12)}}>468x60</option>
                                    <option value="16" {{selected(old('dimension_id'), 16)}}>240x400</option>
                                    <option value="17" {{selected(old('dimension_id'), 17)}}>160x600</option>
                                    <option value="30" {{selected(old('dimension_id'), 30)}}>1x1</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group d-none" id="adJstext">
                            <label class="form-label">{{__('adnetwork.advert_code')}}</label>
                            <div class="form-input">
                                <textarea placeholder="{{__('adnetwork.advert_code')}}" name="text">{{old('text')}}</textarea>
                            </div>
                        </div>

                        <div class="form-group d-none" id="adJsdisplay_name">
                            <label class="form-label">{{__('adnetwork.display_name')}}</label>
                            <div class="form-input">
                                <input placeholder="{{__('adnetwork.display_name')}}" type="text" name="display_name" value="{{old('display_name')}}">
                            </div>
                        </div>

                        <div class="form-group d-none" id="adJsqqfile">
                            <label class="form-label">{{__('adnetwork.advert_file')}}</label>
                            <div class="form-input">
                                <input type="file" name="file"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">{{__('adnetwork.model')}}
                                <i class="popover">
									<span>
                                        {!! __('adnetwork.moderl_id_note') !!}
									</span>
                                </i>
                            </label>
                            <div class="form-select">
                                <select class="select-ns" name="model_id">
                                    <option value="1" {{selected(old('model_id'), 1)}}>CPC</option>
                                    <option value="2" {{selected(old('model_id'), 2)}}>CPM</option>
                                    <option value="3"  {{selected(old('model_id'), 3)}}>CPV</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="budce">{{__('adnetwork.budget_level')}}</label>
                            <div class="form-select">
                                <select class="select-ns" name="budget_level" id="budce">
                                    <option value="1"  {{selected(old('budget_level'), 1)}}>{{__('adnetwork.budget_level_2')}}</option>
                                    <option value="2"  {{selected(old('budget_level'), 2)}}>{{__('adnetwork.budget_level_1')}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="budget_type">{{__('adnetwork.budget_type')}}</label>
                            <div class="f-tbl">
                                <div class="cols">
                                    <div class="col-item col-a mxw-250">
                                        <div class="form-select d-block">
                                            <select class="select-ns" name="budget_type" id="budget_type">
                                                <option value="1"  {{selected(old('budget_type'), 1)}}>{{__('adnetwork.get_spent_daily')}}</option>
                                                <option value="2"  {{selected(old('budget_type'), 2)}}>{{__('adnetwork.budget_type_total')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-item col-a mxw-250">
                                        <div class="form-input d-block">
                                            <input id="budget_planned" value='{{old('budget_planned')}}' name="budget_planned" type="number">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">{{__('adnetwork.budget_bid')}}
                                <i class="popover">
									<span>
	                                    {{__('adnetwork.bid_note')}}
									</span>
                                </i>
                            </label>
                            <div class="f-tbl">
                                <div class="cols">
                                    <div class="col-item col-b">
                                        <div class="form-input d-block in-left">
                                            <span class="in-group">{{__('adnetwork.unit_cost_min')}}</span>
                                            <div class="in-input">
                                                <input @if(old('unit_cost_min')) value="{{old('unit_cost_min')}}" @else value="0" @endif type="text" name="unit_cost_min">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-item col-b">
                                        <div class="form-input d-block in-left">
                                            <span class="in-group">{{__('adnetwork.unit_cost_max')}}</span>
                                            <div class="in-input">
                                                <input type="text" name="unit_cost_max" @if(old('unit_cost_max')) value="{{old('unit_cost_max')}}" @else value="0" @endif >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">{{__('adnetwork.week_day_hours')}} </label>
                            <div class="form-select">
                                <select class="select-ns" name="budget_level" id="week_day_hours_level">
                                    <option value="1">{{__('adnetwork.week_day_hours_level_2')}}</option>
                                    <option value="2" selected="selected">{{__('adnetwork.week_day_hours_level_1')}}</option>
                                </select>
                                <div class="wkd">
                                    <div class="h-target" id="week_day_hours_target" style="">
                                        <div class="h-target-wrap">
                                            <div class="h-target-top">
                                                <ul>
                                                    <li class="h-day"></li>
                                                    @for($i=0; $i<=21; $i+=3)
                                                        <li>@if(strlen($i) == 1)0{{$i}}@else{{$i}} @endif:00</li>
                                                    @endfor
                                                </ul>
                                            </div>
                                            <div class="h-target-a">
                                                @for($i=1; $i<=7; $i++)
                                                    <ul>
                                                        <li class="h-day dy-name">{{__("adnetwork.day_$i")}}</li>
                                                        <li>
                                                            @for($j=0; $j<24; $j++)
                                                                @if($j % 3 ==0 and $j != 0)
                                                        </li> <li>
                                                            @endif
                                                            <span>
                                                           <input id="d{{$i}}{{$j}}" type="checkbox" name="week_day_hours[{{$i}}{{$j}}]" value="{{$i}}{{$j}}">
                                                           <label for="d{{$i}}{{$j}}" title="{{__("adnetwork.day_$i")}} @if(strlen($j) == 1)0{{$j}}@else{{$j}} @endif:00 -  @if(strlen($j+1) == 1)0{{$j}}@else{{$j}} @endif:00"></label>
                                                       </span>

                                                            @endfor
                                                        </li>
                                                    </ul>
                                                @endfor
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-group d-block">
                            <div class="form-select mt-30 d-block">
                                <select class="select-ns" name="targeting" id="targeting">
                                    <option value="0" selected="selected">{{__('adnetwork.targeting_all')}}</option>
                                    <option value="1">{{__('adnetwork.targeting1_text')}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="h-block">
                            <div class="alert alert-info">
                                <button type="button" class="a-close"></button>
                                <strong>{{__('adnetwork.targeting_note_narrow')}}</strong>
                            </div>

                            <div class="form-group">
                                <label class="form-label">{{__('adnetwork.targeting_site_note')}}
                                    <i class="popover">
										<span>
                                            {!! __('adnetwork.targeting_site_note') !!}
										</span>
                                    </i>
                                </label>
                                <div class="f-tbl">
                                    <div class="form-select d-block">
                                        <select class="select-tag sites" name="sites[]" multiple="multiple" style="width: 100%">

                                        </select>
                                    </div>
                                    <span class="badge badge-z mt-5 mbtn" data-target="#websites">{{__('adnetwork.website_list')}}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">{{__('adnetwork.targeting_excludedsite')}}
                                    <i class="popover">
										<span>
                                            {!! __('adnetwork.targeting_excludedsite_note') !!}
										</span>
                                    </i>
                                </label>
                                <div class="f-tbl">
                                    <div class="form-select d-block">
                                        <select class="select-tag sites" multiple="multiple" name="forbidden_sites[]" style="width: 100%">

                                        </select>
                                    </div>
                                    <span class="badge badge-z mt-5 mbtn" data-target="#websites">{{__('adnetwork.website_list')}}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">{{__('adnetwork.frequency')}}
                                    <i class="popover">
										<span>
											{!! __('adnetwork.frequency_note') !!}
										</span>
                                    </i>
                                </label>
                                <div class="form-input">
                                    <div class="switch-wrap">
                                        <div class="switch-button">
                                            <input id="status" name="frequency" value="1" type="checkbox" @if(old('frequency')) checked @endif>
                                            <label for="status"></label>
                                        </div>
                                    </div>
                                    <div class="fq-section">
                                        <div class="form-input">
                                            <input placeholder="Sayı" name="frequency_capping" @if(old('frequency_capping')) value="{{old('frequency_capping')}}" @else value="0" @endif type="text">
                                        </div>
                                        <div class="form-select d-block in-left">
                                            <span class="in-group">{{__('adnetwork.impression')}}</span>
                                            <div class="in-input">
                                                <select class="select-ns" name="frequency_period" id="frequency_period" >
                                                    <option value="" {{selected(old('frequency_period'), '')}}>{{__('adnetwork.all_time')}}</option>
                                                    <option value="day" {{selected(old('frequency_period'), 'day')}}>{{__('adnetwork.one_days')}}</option>
                                                    <option value="week" {{selected(old('frequency_period'), 'week')}}>{{__('adnetwork.one_week')}}</option>
                                                    <option value="month" {{selected(old('frequency_period'), 'month')}}>{{__('adnetwork.one_month')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="form-group">
                            <label class="form-label" for="accelerated">{{__('adnetwork.accelerated')}}</label>
                            <div class="form-select">
                                <select class="select-ns" name="accelerated" id="accelerated">
                                    <option value="0" {{selected(old('accelerated'), 0)}}>{{__('adnetwork.yes')}}</option>
                                    <option value="1"  {{selected(old('accelerated'), 1)}}>{{__('adnetwork.no')}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="no_earning">{!! __('adnetwork.no_earning') !!}</label>
                            <div class="form-select">
                                <select class="select-ns" name="no_earning" id="no_earning">
                                    <option value="0"  {{selected(old('no_earning'), 0)}}>{{__('adnetwork.no_earning_true')}}</option>
                                    <option value="1"  {{selected(old('no_earning'), 1)}}>{!! __('adnetwork.no_earning') !!}</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="no_spent">{{__('adnetwork.nospent')}}</label>
                            <div class="form-select">
                                <select class="select-ns" name="no_spent" id="no_spent">
                                    <option value="0" {{selected(old('no_spent'), 0)}}>{{__('adnetwork.nospent_true')}}</option>
                                    <option value="1" {{selected(old('no_spent'), 1)}}>{{__('adnetwork.nospent')}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="ruser">{{__('adnetwork.ref_user_name')}}</label>
                            <div class="form-input">
                                <input id="ruser"  @if(old('ref_user_id')) value="{{old('ref_user_id')}}" @else value="0" @endif  type="number" max="1" min="0" step="0.1" name="ref_user_id">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="ruserf">{{__('adnetwork.ref_user_name_rate')}}</label>
                            <div class="form-input">
                                <input id="ruserf" @if(old('ref_share_rate')) value="{{old('ref_share_rate')}}" @else value="0" @endif type="number" max="1"  min="0" step="0.1" name="ref_share_rate">
                            </div>
                        </div>


                        <div class="t-center">
                            <button class="a-button b-green" type="submit">{{__('adnetwork.submit')}}</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </div>

    <div id="websites" class="modal">
        <div class="modal-wrap">
            <div class="modal-content">
                <div class="modal-a w-400">
                    <div class="modal-header">
                        <h2 class="md-title">{{__('adnetwork.website_list')}}</h2>
                        <div class="x-close"></div>
                    </div>
                    <div class="modal-body">
                        <div class="ws-list">
                            <ul>
                                <li class="ws-head">
                                    <span class="w-id">ID</span><span class="w-name">{{__('adnetwork.website_name')}}</span>
                                </li>
                                @foreach($sites as $site)
                                <li>
                                    <span class="w-id">#{{$site['site_id']}}</span><span class="w-name">{{$site['domain']}}</span>
                                </li>
                                @endforeach

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('css')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/filepond/4.27.0/filepond.css" integrity="sha512-EWNbfvkOjhWubYsb4fH9xC3auJ+lL9goZexlUfGQqoTDEutmCCI5bUgJ/ilgR6kbqrae7VFGsTOB3ZoBatwYpw==" crossorigin="anonymous" />


    <style>
        .h-block {display:none;}
        .ws-list {overflow:hidden; border:1px solid #d6d6d6; height: 300px; overflow-y: auto;}
        .ws-list ul li {border-bottom:1px solid #d6d6d6; overflow:hidden;}
        .ws-list ul li:last-child {border-bottom:0;}
        .ws-list .w-id {float:left; width:100px; display:block; padding:5px 10px;}
        .ws-list .w-name {overflow:hidden; display:block; padding:5px 10px;}
        .ws-list .ws-head {font-weight:500;}
        .form-group.d-none {display:none;}
    </style>


    <link href="/filepond/src/css/filepond.css" rel="stylesheet">
    <link href="/filepond/dist/filepond-plugin-media-preview.css" rel="stylesheet">
    <link href="/filepond/src/css/filepond-plugin-image-preview.css" rel="stylesheet">

    <style>
        .h-block {display:none;}
        .ws-list {overflow:hidden; border:1px solid #d6d6d6; height: 300px; overflow-y: auto;}
        .ws-list ul li {border-bottom:1px solid #d6d6d6; overflow:hidden;}
        .ws-list ul li:last-child {border-bottom:0;}
        .ws-list .w-id {float:left; width:100px; display:block; padding:5px 10px;}
        .ws-list .w-name {overflow:hidden; display:block; padding:5px 10px;}
        .ws-list .ws-head {font-weight:500;}
        .form-group.d-none {display:none;}
        .filepond-a {position:relative; max-width:300px;}
        .fp-wrap {border: 1px solid #e1e5ef; padding: 3px; border-radius: 3px;}
        #filepond_file {width:100%; display:block; position:relative;}
        .b-level {display:none;}
        .wkd {display:none;}
        .h-target {padding:30px 0 0 0;}
        .h-target .h-target-wrap {min-width:650px;}
        .h-target-top {overflow:hidden;}
        .h-target-top ul {overflow:hidden;}
        .h-target-top ul li {width:63px; float:left; height:20px;}
        .h-target ul li.h-day {width:130px; background-color:transparent !important; border:0 !important; font-weight:bold;}
        .h-target-a {overflow:hidden; padding-top:1px;}
        .h-target-a ul {overflow:hidden; margin-top:-1px;}
        .h-target-a ul li {float:left; background-color:#f5f5f5; border:1px solid #ccc; border-right:0;}
        .h-target-a ul li:last-child {border-right:1px solid #ccc;}
        .h-target-a ul li span {float:left; display:block; width:21px; height:36px; border-right:1px solid #fff;}
        .h-target-a ul li span:last-child {border-right:0; width:20px;}
        .h-target-a ul li input[type="checkbox"] {display:none;}
        .h-target-a ul li span label {display:block; cursor:pointer; height:36px; -webkit-transition: all .3s ease; -moz-transition: all .3s ease; transition: all .3s ease;}
        .h-target-a ul li span label:hover {background-color: rgba(147,159,227, 0.3)}
        .h-target-a ul li input[type="checkbox"]:checked + label {background: rgb(147,159,227); background: linear-gradient(172deg, rgba(147,159,227,1) 0%, rgba(92,107,192,1) 100%);}
        .h-target-a ul li.dy-name {font-size:14px; line-height:20px; padding: 9px 0; text-align:right; padding-right:10px;}
        .fq-section {padding-top:10px; display:none;}
        .fq-section .form-input {display:block; float:left; padding-right:20px; width:120px !important;}
        .fq-section .form-select {display:block; float:left; width:250px !important;}

    </style>
@endsection
@section('js')

    <script>
        $('#week_day_hours_level').on('change',function() {
            if($(this).val() == 1){
                $('.wkd').slideDown();
            } else {
                $('.wkd').slideUp();
                $('.h-target-a input').prop('checked', false);
            }
        });

        $('#status').on('change',function() {
            if(this.checked){
                $('.fq-section').slideDown();
            } else {
                $('.fq-section').slideUp();
                $('.fq-section input').val('');
                $('.fq-section .select-ns').val(null).trigger('change');
            }
        });

        $(document).ready(function() {
            $('select.sites').select2({
                placeholder: "{{__('adnetwork.site_domain')}}",
                language: {
                    searching: function () {
                        return "{{__('adnetwork.searching')}}";
                    }
                },

                ajax: {
                    url: "/api/select/sites",
                    data: function (params) {
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
    <script src="/filepond/dist/filepond-plugin-media-preview.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script>

        function isLoadingCheck(){
            var isLoading = pond.getFiles().filter(x=>x.status !== 5).length !== 0;
            if(isLoading) {
                $('button[type="submit"]').attr("disabled", "disabled");
            } else {
                $('button[type="submit"]').removeAttr("disabled");
            }
        }


        FilePond.registerPlugin(FilePondPluginMediaPreview);
        FilePond.registerPlugin(FilePondPluginImagePreview);

        const inputElement = document.querySelector('input[type="file"]');
        const pond = FilePond.create(inputElement, {
            onaddfilestart: (file) => { isLoadingCheck(); },
            onprocessfile: (files) => { isLoadingCheck(); }
        });


        FilePond.setOptions({

            server: {
                process:(fieldName, file, metadata, load, error, progress, abort, transfer, options) => {

                    // fieldName is the name of the input field
                    // file is the actual file object to send
                    const formData = new FormData();
                    formData.append(fieldName, file, file.name);

                    const request = new XMLHttpRequest();
                    request.open('POST', '/az/advert/files/upload');

                    // Should call the progress method to update the progress to 100% before calling load
                    // Setting computable to false switches the loading indicator to infinite mode
                    request.upload.onprogress = (e) => {
                        progress(e.lengthComputable, e.loaded, e.total);
                    };

                    // Should call the load method when done and pass the returned server file id
                    // this server file id is then used later on when reverting or restoring a file
                    // so your server knows which file to return without exposing that info to the client
                    request.onload = function () {
                        // console.log(response)
                        if (request.status >= 200 && request.status < 300) {
                            console.log(request.responseText.filename)
                            // $("#image_url").val
                            // the load method accepts either a string (id) or an object
                            load(request.responseText);
                        } else {
                            // Can call the error method if something is wrong, should exit after
                            error('oh no');
                        }
                    };

                    request.send(formData);
                },
                revert: '/az/advert/files/delete',
                restore: 'filepond/restore?id=',
                fetch: 'filepond/fetch?data=',
                load: 'filepond/load',
            }
        });

    </script>
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/filepond/4.27.0/filepond.min.js" integrity="sha512-xqJsP8aZZAF5zkXmst5/KF7jXO9q9F1JFH/RGUa1hDjLUx6v6Nl9TpbfVAiFuAHCyZFkUrqHyvG/EODv0QEM8w==" crossorigin="anonymous"></script>--}}
    <script>
        $('#w-format').on('change',function() {
            if($(this).val() == 12){
                $('#adJsnamelabel').text('Xəbər başlığı');
            } else {
                $('#adJsnamelabel').text("{{__('adnetwork.advert_name')}}");
            }

            if($(this).val() == 10 || $(this).val() == 11){
                $('#adJsdimension_id').show();
            } else {
                $('#adJsdimension_id').hide();
            }

            if($(this).val() != 10){
                $('#adJsqqfile').show();
            } else {
                $('#adJsqqfile').hide();
            }

            if($(this).val() != 10 && $(this).val() != 261){
                $('#adJstext').hide();
            } else {
                $('#adJstext').show();
            }

            if($(this).val() == 261){
                $('#adJsdisplay_name').show();
            } else {
                $('#adJsdisplay_name').hide();
            }
        });

        $('#w-format').trigger('change');


        $('#targeting').on('change',function() {
            if($(this).val() == 1){
                $('.h-block').slideDown();
            } else {
                $('.h-block').slideUp();
            }
        });

    </script>




@endsection
