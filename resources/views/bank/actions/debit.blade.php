@extends('layouts.app')
@section('title', __('adnetwork.debit'))
@section('content')
    <div class="content-inner">
        <div class="breadcrumb">
            <ul>
                <li><a href="{{route('dashboard', app()->getLocale())}}">Smartbee</a></li>
                <li><a href="{{route('bank.accounting.index', app()->getLocale())}}">{{__('adnetwork.bank_account_transactions')}}</a></li>
                <li><span>{{__('adnetwork.debit')}}</span></li>
            </ul>
        </div>


        @include('partials.cards')


        <div class="a-block a-center">
            <div class="a-block-head">
                {{ __('adnetwork.debit')}}


            </div>
            <div class="a-block-body">
                <form action="{{route('bank.accounting.transaction.debit.edit', ['lang' => app()->getLocale(), 'id' => $transaction['id']])}}" method="post">
                    @csrf
                    @include('flash-message')

                    <div class="form-group">
                        <label class="form-label" for="entity_type">{{__('adnetwork.entity_type')}} </label>
                        <div class="form-select">
                            <select class="select-ns" style="width: 100%" name="entity_type" data-placeholder="{{__('adnetwork.entity_type')}}" id="entity_type" >
{{--                                <option value="1">{{__('adnetwork.service')}}</option>--}}
                                <option value="2">{{__('adnetwork.campaign')}}</option>
                                <option value="3" selected>{{__('adnetwork.agency')}}</option>
                            </select>
                            @error('entity_id')
                            <div class="notification-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="entity_id">{{__('adnetwork.entity_id')}} </label>
                        <div class="form-select">
                            <select class="select-ns" style="width: 100%" name="entity_id" data-placeholder="{{__('adnetwork.entity_id')}}" id="entity_id" >

                            </select>
                            @error('entity_id')
                            <div class="notification-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="form-label" for="entity_id">{{__('adnetwork.description')}} </label>
                        <div class="form-input">
                            <input id="description" name="description" type="text" value="{{$transaction['description']}}">

                            @error('description')
                            <div class="notification-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    <div id="debitor_area">

                    </div>


                    <div class="t-center" style="margin-top: 10px;">
                        <button class="a-button b-green" type="submit">{{__('adnetwork.submit')}}</button>


                        <a class="a-button b-gr f-right with-icon b-small" style="background-color: red; border-color: red !important;" id="debit_amount"
                           @if($transaction['bt_amount'] == null) data-debit="{{$transaction['debit']}}" @else data-debit="{{$transaction['debit']-$transaction['bt_amount']}}" @endif>
                            @if($transaction['bt_amount'] == null) {{$transaction['debit']}} @else {{$transaction['debit']-$transaction['bt_amount']}} @endif
                        </a>

                        <a class="a-button b-gr f-right with-icon b-small" id="debit_total" style="margin-right: 5px; display: none"></a>


                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection

@section('js')
    <script>

        var debit = parseFloat($("#debit_amount").attr('data-debit'));

        $(document).ready(function(){
            function calculate(){
                let value = 0;
                $( ".campaign_debit" ).each(function( index ) {
                    value = value + parseFloat($(this).val())
                });
                let lastAmount = debit-value;
                $("#debit_amount").text(lastAmount)

            }

            function debitTotal(){
                let total = 0;
                console.log('aaa')
                $( ".campaign_amount" ).each(function( index ) {
                    total = total + parseFloat($(this).attr('data-amount'))
                    // $("#debit_total").show()
                    $("#debit_total").html(total)
                    $("#debit_total").css('display', 'block')
                });
            }
            function select2_function(type){
                $("#debitor_area").html('');
                $("#debit_amount").text(debit)
                let selectType = '1';
                if (type == 'articles_sites') {
                    selectType = '';
                }
                else if(type == '2'){
                    selectType = 'campaigns';
                }
                else if(type == '3'){
                    selectType = 'agencies';
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

            $("#entity_id").change(function (){
                $("#debit_total").css('display', 'none')

                let type = $('#entity_type').val();
                let id = $('#entity_id').val();
                $.ajax({
                    type:"POST",
                    data: {
                        'type': type,
                        'id': id,
                        "_token": "{{ csrf_token() }}",
                        'transaction_id' : "{{$transaction['id']}}"
                    },
                    url:'/az/bank/debitors/get/finance',
                    success:function(response){
                        $("#debitor_area").html(response)
                        calculate();
                        debitTotal();
                    }
                });

            })

            $('body').on('change', '.campaign_debit', function() {
                calculate();

            });

            $('body').on('click', '.campaign_amount', function() {
                let amount = $(this).attr('data-amount');
                let campaignId = $(this).attr('data-campaign-id')

                let campaignInput = "#campaigns"+campaignId;
                $(campaignInput).val(amount)
                calculate()
            });



        });


    </script>
@endsection
