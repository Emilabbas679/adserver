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
                <form action="{{route('adset.edit', ['lang' => app()->getLocale(), 'id'=>$item['set_id']])}}" method="post">
                    @csrf

                    <div class="form-group">
                        <label class="form-label" for="campaign_name">{{__('adnetwork.campaign')}}</label>
                        <div class="form-input">
                            <input id="campaign_name" value='{{$item['campaign_name']}}' name="campaign_name" type="text" disabled>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="form-label" for="group">{{__('adnetwork.group')}}</label>
                        <div class="form-input">
                            <input id="group" value='{{$item['name']}}' name="name" type="text">
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="form-label" for="budget_type">{{__('adnetwork.budget_type')}}</label>
                        <div class="cols">
                            <div class="col-item col-a mxw-250">
                                <div class="form-select">
                                    <select class="select-ns" name="budget_type" id="budget_type">
                                        <option value="1" {{selected(1, $item['budget_type'])}}>{{__('adnetwork.total')}}</option>
                                        <option value="2" {{selected(2, $item['budget_type'])}}>{{__('adnetwork.day')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-item col-a mxw-250">
                                <div class="form-input">
                                    <input id="budget_planned" value='{{$item['budget_planned']}}' name="budget_planned" type="number">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="campaign_name">{{__('adnetwork.start_date')}}</label>
                        <div class="cols">
                            <div class="col-item col-a">
                                <div class="form-input f-calendar">
                                    <input id="start_date" value='{{date('d.M.y', $item['start_time'])}}' name="start_date" type="text" data-toggle="datepicker" >
                                    <i></i>
                                </div>
                            </div>
                            <div class="col-item col-a">
                                <div class="form-input f-time">
                                    <input id="start_date_time" value='{{date('H:i', $item['start_time'])}}' name="start_date_time" type="text" class="bs-timepicker" >
                                    <i></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="end_date">{{__('adnetwork.end_date')}}</label>
                        <div class="cols">
                            <div class="col-item col-a">
                                <div class="form-input f-calendar">
                                    <input id="end_date" value='{{date('d.m.Y', $item['end_time'])}}' name="end_date" type="text" data-toggle="datepicker">
                                    <i></i>
                                </div>
                            </div>
                            <div class="col-item col-a">
                                <div class="form-input f-time">
                                    <input id="end_date_time" value='{{date('H:i', $item['end_time'])}}' name="end_date_time" type="text" class="bs-timepicker" >
                                    <i></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="cols">
                            <div class="col-item col-a">
                                <label class="form-label" for="os_id">{{__('adnetwork.os')}}</label>
                                @php $os = (array) json_decode($item['os_id']); @endphp
                                <div class="form-select">
                                    <select class="b-select" name="os_id[]" id="os_id" multiple size="3">
                                        <option value="22" @if(count($os) == 0 or in_array("22", $os)) selected @endif>{{__('adnetwork.windows')}}</option>
                                        <option value="23" @if(count($os) == 0 or in_array("23", $os)) selected @endif>{{__('adnetwork.ios')}}</option>
                                        <option value="24" @if(count($os) == 0 or in_array("24", $os)) selected @endif>{{__('adnetwork.android')}}</option>
                                        <option value="81" @if(count($os) == 0 or in_array("81", $os)) selected @endif>{{__('adnetwork.other')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-item col-a">
                                <label class="form-label" for="device_id">{{__('adnetwork.devices')}}</label>
                                @php $devices = (array) json_decode($item['device_id']); @endphp
                                <div class="form-select">
                                    <select class="a-select" name="device_id[]" id="device_id" multiple size="3">
                                        <option value="16" @if(count($devices) == 0 or in_array("16", $devices)) selected @endif>{{__('adnetwork.computer')}}</option>
                                        <option value="17" @if(count($devices) == 0 or in_array("17", $devices)) selected @endif>{{__('adnetwork.mobile')}}</option>
                                        <option value="18" @if(count($devices) == 0 or in_array("18", $devices)) selected @endif>{{__('adnetwork.tablet')}}</option>
                                        <option value="77" @if(count($devices) == 0 or in_array("77", $devices)) selected @endif>{{__('adnetwork.other')}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="cols">
                            <div class="col-item col-a">
                                <label class="form-label" for="connection_type_id">{{__('adnetwork.connection_type_id')}}</label>
                                @php $cns = (array) json_decode($item['connection_type_id']); @endphp
                                <div class="form-select">
                                    <select class="c-select" name="connection_type_id[]" id="connection_type_id" multiple size="2">
                                        <option value="28" @if(count($cns) == 0 or in_array("28", $cns)) selected @endif>{{__('adnetwork.mobile_connection')}}</option>
                                        <option value="29" @if(count($cns) == 0 or in_array("29", $cns)) selected @endif>{{__('adnetwork.ethernet')}}</option>
                                        <option value="80" @if(count($cns) == 0 or in_array("80", $cns)) selected @endif>{{__('adnetwork.undefined')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-item col-a">
                                <label class="form-label" for="operator_id">{{__('adnetwork.operators')}}</label>
                                @php $ops = (array) json_decode($item['operator_id']); @endphp
                                <div class="form-select">
                                    <select class="d-select" name="operator_id[]" id="operator_id" multiple size="1">
                                        <option value="25" @if(count($ops) == 0 or in_array("25", $ops)) selected @endif>{{__('adnetwork.azercell')}}</option>
                                        <option value="26" @if(count($ops) == 0 or in_array("26", $ops)) selected @endif>{{__('adnetwork.bakcell')}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="cols">
                            <div class="col-item col-a">
                                <label class="form-label" for="age_group_id">{{__('adnetwork.age_group')}}</label>
                                @php $ages = (array) json_decode($item['age_group_id']); @endphp

                                <div class="form-select">
                                    <select class="e-select" name="age_group_id[]" id="age_group_id" multiple size="4">
                                        <option value="30508" @if(count($ages) == 0 or in_array("30508", $ages)) selected @endif>{{__('adnetwork.other')}}</option>
                                        <option value="30509" @if(count($ages) == 0 or in_array("30509", $ages)) selected @endif>18-24</option>
                                        <option value="30510" @if(count($ages) == 0 or in_array("30510", $ages)) selected @endif>25-34</option>
                                        <option value="30511" @if(count($ages) == 0 or in_array("30511", $ages)) selected @endif>35-44</option>
                                        <option value="30512" @if(count($ages) == 0 or in_array("30512", $ages)) selected @endif>45-54</option>
                                        <option value="30513" @if(count($ages) == 0 or in_array("30513", $ages)) selected @endif>55-64</option>
                                        <option value="30514" @if(count($ages) == 0 or in_array("30514", $ages)) selected @endif>65+</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-item col-a">
                                <label class="form-label" for="gender">{{__('adnetwork.gender')}}</label>
                                @php $gns = (array) json_decode($item['gender']); @endphp
                                <div class="form-select">
                                    <select class="f-select" name="gender[]" id="gender" multiple>
                                        <option value="30515" @if(count($gns) == 0 or in_array("30515", $gns)) selected @endif>{{__('adnetwork.male')}}</option>
                                        <option value="30516" @if(count($gns) == 0 or in_array("30516", $gns)) selected @endif>{{__('adnetwork.female')}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="country_id">{{__('adnetwork.countries')}}</label>
                        @php $cnts = (array) json_decode($item['country_id']); @endphp
                        <div class="form-select">
                            <select class="g-select" name="country_id[]" id="country_id" multiple>
                                <option value="AZ" @if( in_array("AZ", $cnts)) selected @endif>{{__('adnetwork.azerbaijan')}}</option>
                            </select>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="form-label" for="tags">{{__('adnetwork.tags')}}</label>
                        <div class="form-input">
                            <input id="tags" class="b-tag" name="tags" type="text" value="{{implode(',', (array) json_decode($item['tags']))}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="tags2">{{__('adnetwork.negative_tags')}}</label>
                        <div class="form-input">
                            <input id="tags2" class="b-tag2" name="negative_tags" type="text" value="{{implode(',', (array) json_decode($item['negative_tags']))}}">
                        </div>
                    </div>

                    <div class="t-center">
                        <button class="a-button b-green" type="submit">{{__('admin.submit')}}</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
@section('css')
    <link media="screen" href="/css/timepicker.css?v6" type="text/css" rel="stylesheet" />
    <link media="screen" href="/css/vanillaSelectBox.css?41" type="text/css" rel="stylesheet" />
    <link media="screen" href="/css/tagify.css?53" type="text/css" rel="stylesheet" />
@endsection
@section('js')
    <script type="text/javascript" src="/js/datepicker.min.js"></script>
    <script type="text/javascript" src="/js/timepicker.min.js"></script>
    <script type="text/javascript" src="/js/vanillaSelectBox.js?v201"></script>
    <script type="text/javascript" src="/js/tagify.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="datepicker"]').datepicker({
                autoHide: true,
                autoPick: true,
                format: 'dd.mm.yyyy'
            });

            $('.bs-timepicker').timepicker();

            let mySelect = new vanillaSelectBox(".b-select",{
                placeHolder: "Seçim edin",
                translations: {
                    "items": "seçilən"
                }
            });
            let mySelect2 = new vanillaSelectBox(".a-select",{
                placeHolder: "Seçim edin",
                translations: {
                    "items": "seçilən"
                }
            });
            let mySelect3 = new vanillaSelectBox(".c-select",{
                placeHolder: "Seçim edin",
                translations: {
                    "items": "seçilən"
                }
            });
            let mySelect4 = new vanillaSelectBox(".d-select",{
                placeHolder: "Seçim edin",
                translations: {
                    "items": "seçilən"
                }
            });
            let mySelect5 = new vanillaSelectBox(".e-select",{
                placeHolder: "Seçim edin",
                translations: {
                    "items": "seçilən"
                }
            });
            let mySelect6 = new vanillaSelectBox(".f-select",{
                placeHolder: "Seçim edin",
                translations: {
                    "items": "seçilən"
                }
            });
            let mySelect7 = new vanillaSelectBox(".g-select",{
                placeHolder: "Seçim edin",
                translations: {
                    "items": "seçilən"
                }
            });
            var tags = document.querySelector('.b-tag');
            new Tagify(tags)
            var tags2 = document.querySelector('.b-tag2');
            new Tagify(tags2)
        });
    </script>

@endsection
