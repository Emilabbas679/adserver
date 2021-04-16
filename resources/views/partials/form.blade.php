@foreach($form as $data)


    @if($data['type'] == 'input:hidden')
	<input id="adJs{{$data['id']}}" type="hidden" id="{{$data['id']}}" name="{{$data['id']}}" value='{{$data['value']}}'>

    @elseif($data['type'] == 'input:text')
    <div class="form-group">
        <label class="form-label" for="{{$data['id']}}">@if(isset($data['required']) and $data['required'])  required @endif {{$data['title']}}</label>
        <div class="form-input">
            <input id="{{$data['id']}}" value='{{$data['value']}}' name="{{$data['id']}}" type="text" placeholder="{{$data['title']}}">
        </div>
    </div>
    @elseif($data['type'] == 'input:password')
    <div class="form-group">
        <label class="form-label" for="{{$data['id']}}">{{$data['title']}}</label>
        <div class="form-input">
            <input id="{{$data['id']}}" type="password" value='{{$data['value']}}' name="{{$data['id']}}" type="text" autocomplete="off" placeholder="{{$data['title']}}">
        </div>
    </div>

    @elseif($data['type'] == 'input:readonly')
    <div class="form-group">
        <label class="form-label" for="{{$data['id']}}"> {{$data['title']}}</label>
        <div class="form-input">
            <input  id="{{$data['id']}}" name="{{$data['id']}}" readonly type="text" value="{{$data['value']}}">
        </div>
    </div>

    @elseif($data['type'] == 'input:staff_search')
    <div class="form-group">
        <label class="form-label" for="u-number">@if(isset($data['required']) and $data['required'])  required @endif {{$data['title']}}</label>
        <div class="form-input">
			<div class="col-right">
				<button class="b-scn a-button" type="submit">{{__('admin.staff_search')}}</button>
			</div>
			<div class="col-fr">
				<input id="u-number" value='{{$data['value']}}' name="{{$data['id']}}" type="text" placeholder="{{$data['title']}}">
			</div>
        </div>
    </div>


    @elseif($data['type'] == 'input:full_name')
    <div class="form-group">
        <label class="form-label" for="l-name">@if(isset($data['required']) and $data['required'])  required @endif {{$data['title']}}</label>
        <div class="form-input">
            <div class="cols">
                <div class="col-item col-b">
                    <input id="l-name" name="{{$data['lastname']}}" value='{{$data['lastname']}}' type="text" placeholder="{{__('placeholders.lastname')}}">
                </div>
                <div class="col-item col-b">
                    <input type="text" name="{{$data['firstname']}}" value='{{$data['firstname']}}' placeholder="{{__('placeholders.firstname')}}">
                </div>
                <div class="col-item col-b">
                    <input type="text" name="{{$data['father_name']}}" value='{{$data['father_name']}}' placeholder="{{__('placeholders.father_name')}}">
                </div>
            </div>
        </div>
    </div>

    @elseif($data['type'] == 'select')
    <div class="form-group">
        <label class="form-label" for="company">{{$data['title']}}</label>
        <div class="form-select">
            <select class="select-ns" name="{{$data['id']}}" data-placeholder="{{$data['placeholder']}}" id="{{$data['id']}}" @if(isset($data['disabled']) and $data['disabled'] == true ) disabled @endif>
                @foreach($data['options'] as $option)
                    <option value="{{$option['id']}}" @if($option['selected'] == 1) selected @endif>{{$option['text']}}</option>
                @endforeach
            </select>
        </div>
    </div>

    @elseif($data['type'] == 'select2')
        <div class="form-group">
            <label class="form-label" for="{{$data['id']}}">{{$data['title']}} </label>
            <div class="form-select">
                <select class="select-ns" style="width: 100%" name="{{$data['name']}}" data-placeholder="{{$data['placeholder']}}" id="{{$data['id']}}" @if(isset($data['disabled']) and $data['disabled'] == true ) disabled @endif>
                    @foreach($data['options'] as $option)
                        <option value="{{$option['id']}}" @if($option['selected'] == 1) selected @endif>{{$option['text']}}</option>
                    @endforeach
                </select>
            </div>
        </div>


    @else

	<div class="form-group row" id="adJs{{$data['id']}}" @if(isset($aData['display'])) style="display: none;" @endif>
		<label class="col-form-label col-lg-3">{{__('admin.campaign_name')}}{required}</label>
		<div class="col-lg-9">
			<input type="hidden" name="{{$data['id']}}" value="{{$data['id']}}">
			 <input type="text" name="{{$data['name']}}" value="{{$data['name']}}" class="form-control" readonly="" >
		</div>
	</div>

    @endif

@endforeach

