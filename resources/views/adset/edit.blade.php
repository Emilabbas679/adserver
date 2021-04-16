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
                        <div class="form-input">
                            <select name="budget_type" id="budget_type" style="width: 50%; display: inline-block; float: left">
                                <option value="1" {{selected(1, $item['budget_type'])}}>{{__('adnetwork.total')}}</option>
                                <option value="2" {{selected(2, $item['budget_type'])}}>{{__('adnetwork.day')}}</option>
                            </select>
                            <input id="budget_planned" value='{{$item['budget_planned']}}' name="budget_planned" type="text" style="display: inline-block;  width: 50%">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="campaign_name">{{__('adnetwork.start_date')}}</label>
                        <div class="form-input">
                            <input id="start_date" value='{{date('Y-m-d', $item['start_time'])}}' name="start_date" type="date" disabled>
                            <input id="start_date_time" value='{{date('H:i:s', $item['start_time'])}}' name="start_date_time" type="time" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="campaign_name">{{__('adnetwork.end_date')}}</label>
                        <div class="form-input">
                            <input id="end_date" value='{{date('Y-m-d', $item['end_time'])}}' name="start_date" type="date" >
                            <input id="end_date_time" value='{{date('H:i:s', $item['end_time'])}}' name="start_date_time" type="time" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="os_id">{{__('adnetwork.os')}}</label>
                        @php $os = (array) json_decode($item['os_id']); @endphp

                        <div class="form-input">
                            <select name="os_id" id="os_id" multiple>
                                <option value="" @if(count($os) == 0 or in_array("", $os)) selected @endif>{{__('adnetwork.windows')}}</option>
                                <option value="" @if(count($os) == 0 or in_array("", $os)) selected @endif>{{__('adnetwork.ios')}}</option>
                                <option value="" @if(count($os) == 0 or in_array("", $os)) selected @endif>{{__('adnetwork.android')}}</option>
                                <option value="" @if(count($os) == 0 or in_array("", $os)) selected @endif>{{__('adnetwork.other')}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="device_id">{{__('adnetwork.devices')}}</label>
                        @php $devices = (array) json_decode($item['device_id']); @endphp
                        <div class="form-input">
                            <select name="device_id" id="device_id" multiple>
                                <option value="" @if(count($devices) == 0 or in_array("", $devices)) selected @endif>{{__('adnetwork.computer')}}</option>
                                <option value="" @if(count($devices) == 0 or in_array("", $devices)) selected @endif>{{__('adnetwork.mobile')}}</option>
                                <option value="" @if(count($devices) == 0 or in_array("", $devices)) selected @endif>{{__('adnetwork.tablet')}}</option>
                                <option value="" @if(count($devices) == 0 or in_array("", $devices)) selected @endif>{{__('adnetwork.other')}}</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="campaign_name">{{__('adnetwork.connection_type_id')}}</label>
                        @php $cns = (array) json_decode($item['connection_type_id']); @endphp
                        <div class="form-input">
                            <select name="os_id" id="os_id" multiple>
                                <option value="" @if(count($cns) == 0 or in_array("", $cns)) selected @endif>{{__('adnetwork.mobile_connection')}}</option>
                                <option value="" @if(count($cns) == 0 or in_array("", $cns)) selected @endif>{{__('adnetwork.ethernet')}}</option>
                                <option value="" @if(count($cns) == 0 or in_array("", $cns)) selected @endif>{{__('adnetwork.undefined')}}</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="operator_id">{{__('adnetwork.operators')}}</label>
                        @php $ops = (array) json_decode($item['operator_id']); @endphp
                        <div class="form-input">
                            <select name="operator_id" id="operator_id" multiple>
                                <option value="" @if(count($ops) == 0 or in_array("", $ops)) selected @endif>{{__('adnetwork.azercell')}}</option>
                                <option value="" @if(count($ops) == 0 or in_array("", $ops)) selected @endif>{{__('adnetwork.bakcell')}}</option>
                            </select>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="form-label" for="operator_id">{{__('adnetwork.age_group')}}</label>
                        @php $ages = (array) json_decode($item['age_group_id']); @endphp
                        <div class="form-input">
                            <select name="age_group_id" id="age_group_id" multiple>
                                <option value="" @if(count($ages) == 0 or in_array("", $ages)) selected @endif>{{__('adnetwork.other')}}</option>
                                <option value="" @if(count($ages) == 0 or in_array("", $ages)) selected @endif>18-24</option>
                                <option value="" @if(count($ages) == 0 or in_array("", $ages)) selected @endif>25-34</option>
                                <option value="" @if(count($ages) == 0 or in_array("", $ages)) selected @endif>35-44</option>
                                <option value="" @if(count($ages) == 0 or in_array("", $ages)) selected @endif>45-54</option>
                                <option value="" @if(count($ages) == 0 or in_array("", $ages)) selected @endif>55-64</option>
                                <option value="" @if(count($ages) == 0 or in_array("", $ages)) selected @endif>65+</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="gender">{{__('adnetwork.gender')}}</label>
                        @php $gns = (array) json_decode($item['gender']); @endphp
                        <div class="form-input">
                            <select name="gender" id="gender" multiple>
                                <option value="" @if(count($gns) == 0 or in_array("", $gns)) selected @endif>{{__('adnetwork.male')}}</option>
                                <option value="" @if(count($gns) == 0 or in_array("", $gns)) selected @endif>{{__('adnetwork.female')}}</option>
                            </select>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="form-label" for="country_id">{{__('adnetwork.countries')}}</label>
                        @php $cns = (array) json_decode($item['country_id']); @endphp
                        <div class="form-input">
                            <select name="country_id" id="country_id" multiple>
                                <option value="" @if(count($cns) == 0 or in_array("", $cns)) selected @endif>{{__('adnetwork.azerbaijan')}}</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="tags">{{__('adnetwork.tags')}}</label>
                        @php $tags = (array) json_decode($item['tags']); @endphp
                        <div class="form-input">
                            <select name="tags" id="tags" multiple>
                                @foreach($tags as $tag)
                                    <option value="{{$tag}}" selected>{{$tag}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="form-label" for="negative_tags">{{__('adnetwork.negative_tags')}}</label>
                        @php $negative_tags = (array) json_decode($item['negative_tags']); @endphp
                        <div class="form-input">
                            <select name="negative_tags" id="negative_tags" multiple>
                                @foreach($negative_tags as $tag)
                                    <option value="{{$tag}}" selected><{{$tag}}</option>
                                @endforeach
                            </select>
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
@section('js')

@endsection
