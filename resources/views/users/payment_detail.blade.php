@extends('layouts.app')
@section('title', $item['full_name'])
@section('content')
    <div class="content-inner">
        <div class="breadcrumb">
            <ul>
                <li><a href="{{route('dashboard', app()->getLocale())}}">{{__('adnetwork.home')}}</a></li>
                <li><a href="{{route('users.index', app()->getLocale())}}">{{__('adnetwork.users')}}</a></li>
                <li><span>{{$item['full_name']}}</span></li>

            </ul>
        </div>

        @include('partials.cards')


        <div class="a-block a-center">
            <div class="a-block-head">
                {{$item['full_name']}}
            </div>
            <div class="a-block-body">
                <form action="{{route('users.edit_payment', ['lang' => app()->getLocale(), 'id' => $item['user_id']])}}" method="post">
                    @csrf
                    @include('flash-message')

                    <div class="form-group" >
                        <label class="form-label">{{__('adnetwork.tel')}}</label>
                        <div class="form-input">
                            <input type="text" disabled value="{{$item['phone']}}">
                        </div>
                    </div>
                    <div class="form-group" >
                        <label class="form-label">{{__('adnetwork.email')}}</label>
                        <div class="form-input">
                            <input type="text" disabled value="{{$item['email']}}">
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="form-label" for="payment_provider">{{__('adnetwork.payment_provider')}}</label>
                        <div class="form-select">
                            <select class="select-ns" name="payment_provider" data-placeholder="{{__('adnetwork.payment_provider')}}" id="payment_provider" >
                                <option value="1" @if(isset($item['payment_info']['payment_provider']) and $item['payment_info']['payment_provider'] == '1') selected @endif>{{__('adnetwork.card_to_card')}}</option>
                                <option value="2" @if(isset($item['payment_info']['payment_provider']) and $item['payment_info']['payment_provider'] == '2') selected @endif>{{__('adnetwork.bank')}}</option>
                            </select>
                        </div>
                        @error('payment_provider')
                        <div class="notification-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group" id="voen_div">
                        <label class="form-label" for="voen">{{__('adnetwork.voen')}}</label>
                        <div class="form-input">
                            <input id="voen" type="text" name="voen" placeholder="{{__('adnetwork.voen')}}"  @if(isset($item['payment_info']['voen'])) value="{{$item['payment_info']['voen']}}" @endif>
                        </div>
                        @error('voen')
                        <div class="notification-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div id="card_details">

                        <div class="form-group">
                            <label class="form-label" for="bank_card">{{__('adnetwork.bank_card')}}</label>
                            <div class="form-input">
                                <input id="bank_card" name="bank_card" type="text" placeholder="0000 0000 0000 0000"  @if(isset($item['payment_info']['bank_card'])) value="{{$item['payment_info']['bank_card']}}" @endif>
                            </div>
                            @error('bank_card')
                            <div class="notification-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="bank_card_end_date">{{__('adnetwork.bank_card_end_date')}}</label>
                            <div class="form-input">
                                <input id="bank_card_end_date" type="text" name="bank_card_end_date" placeholder="{{__('adnetwork.bank_card_end_date')}}"  @if(isset($item['payment_info']['bank_card_end_date'])) value="{{$item['payment_info']['bank_card_end_date']}}" @endif>
                            </div>
                            @error('bank_card_end_date')
                            <div class="notification-error">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>


                    <div class="form-group">
                        <label class="form-label" for="status_id">{{__('adnetwork.status_id')}}</label>
                        <div class="form-select">
                            <select class="select-ns" name="status_id" data-placeholder="{{__('adnetwork.status_id')}}" id="status_id" >
                                @foreach(status_options() as $opt)
                                    @if($opt['id'] != null)
                                        <option value="{{$opt['id']}}" @if(isset($item['payment_info']['status_id']) and $item['payment_info']['status_id'] == $opt['id']) selected @endif>{{$opt['text']}}</option>
                                        @endif
                                @endforeach

                            </select>
                        </div>
                        @error('payment_provider')
                        <div class="notification-error">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="t-center">
                        <button class="a-button b-green" type="submit">{{__('adnetwork.submit')}}</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection

@section('js')
{{--    <script src="https://rawgithub.com/RobinHerbots/jquery.inputmask/2.x/dist/jquery.inputmask.bundle.js"></script>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.5/jquery.inputmask.min.js" integrity="sha512-sR3EKGp4SG8zs7B0MEUxDeq8rw9wsuGVYNfbbO/GLCJ59LBE4baEfQBVsP2Y/h2n8M19YV1mujFANO1yA3ko7Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <script>
        function action_change(action_id){
            if (action_id == 1) {
                $("#voen_div").hide();
                $("#card_details").show();
            }
            else{
                $("#voen_div").show();
                $("#card_details").hide();
            }
        }
        action_change($("#payment_provider").val());

        $("#payment_provider").change(function (){
            action_change($("#payment_provider").val());
        });




        $("#bank_card_end_date").inputmask({"mask": "99/99"});


    </script>

@endsection
