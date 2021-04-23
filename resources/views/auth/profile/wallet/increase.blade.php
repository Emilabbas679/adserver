@extends('layouts.app')
@section('title', __('titles.wallet_increase'))
@section('title', '')
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
            <div class="a-block-head">{{__('adnetwork.create')}}</div>
            <div class="a-block-body">
                <form action="{{route('wallet_increase', ['lang' => app()->getLocale()])}}" method="post">
                    @csrf
                    @include('flash-message')

                    <div class="form-group">
                        <label class="form-label" for="email">{{__('adnetwork.email')}}</label>
                        <div class="form-input">
                            <input id="email"  name="email" type="text" value="{{ $item->email}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="phone">{{__('adnetwork.phone_number')}}</label>
                        <div class="form-input">
                            <input id="phone" name="phone" type="text" value="{{ $item->phone}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="amount">{{__('adnetwork.amount')}}</label>
                        <div class="form-input">
                            <input id="amount" name="amount" type="text" value="1">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="method">{{__('adnetwork.method')}}</label>
                        <div class="form-select">
                            <select name="action_id" id="method" class="g-select">
                                <option value="41">{{__('adnetwork.bank_card')}}</option>
                                <option value="31">{{__('adnetwork.cash')}}</option>
                                <option value="32">{{__('adnetwork.bank_transfer')}}</option>
                                <option value="22">{{__('adnetwork.bank_transfer')}}</option>
                            </select>
                        </div>
                    </div>


                    <div class="form-group" id="cardTypeBlock">
                        <label class="form-label" for="cardType">{{__('adnetwork.cardType')}}</label>
                        <div class="form-select">
                            <select name="cardType" id="cardType" class="g-select">
                                <option value="0">Visa</option>
                                <option value="1">Mastercard</option>

                            </select>
                        </div>
                    </div>


                    <div class="row walletinfo" id="ad_wallet_form_action_31" style="display: none;">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-primary text-white header-elements-inline">
                                    <h6 class="card-title">Nağd ödəniş</h6>
                                </div>

                                <div class="card-body">
                                    Adminstrasiya ilə əlaqə saxlayın
                                    Tel: 055 204 62 44
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row walletinfo" id="ad_wallet_form_action_32" style="display: none;">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-primary text-white header-elements-inline">
                                    <h6 class="card-title">Bank köçürmə</h6>
                                </div>

                                <div class="card-body">
                                    <b>Müştəri kodu:</b> 683391  <br>
                                    <b>Hesab sahibi:</b> "ADSAN.AZ" MƏHDUD MƏSULİYYƏTLİ CƏMİYYƏTİ  <br>
                                    <b>Hesab nömrəsi:</b> 380300001326904A59  <br>
                                    <b>IBAN:</b> AZ72JBBK00380300001326904A59  <br>
                                    <b>Bank adı:</b> Bank of Baku ASC -nin "Mərkəz" filiali  <br>
                                    <b>VOEN:</b> 1700038881  <br>
                                    <b>Kod:</b> 507592 <br>
                                    <b>Müxbir hesab:</b> AZ27NABZ01350100000000007944  <br>
                                    <b>S.W.I.F.T:</b> JBBKAZ22  <br>
                                    <b>Tel.:</b> (994 12) 437 22 00  <br>
                                    <b>Faks:</b> (994 12) 437 23 00  <br>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row walletinfo" id="ad_wallet_form_action_22" style="display: none;">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-primary text-white header-elements-inline">
                                    <h6 class="card-title">Admin ödəniş paneli</h6>
                                </div>

                                <div class="card-body">
                                    Admin tərəfindən ödəniş olunduqda heç ödəniş nəğd şəkildə şirkət tərəfindən alınmalıdır.										</div>
                            </div>
                        </div>
                    </div>
                    <div class="row walletinfo" id="ad_wallet_form_action_41" style="display: block;">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-primary text-white header-elements-inline">
                                    <h6 class="card-title">Online ödəniş</h6>
                                </div>

                                <div class="card-body">
                                    Əməliyyat "Bank of Baku"nun prosessinq mərkəzi vasitəsi ilə həyata keçirilir.
                                </div>
                            </div>
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
    <script>
        $("#method").change(function (){
           let method = $(this).val();
           if (method == 41) {
               $("#cardTypeBlock").css('display', 'show');
           }
           else{
               $("#cardTypeBlock").css('display', 'none');
           }
           $(".walletinfo").css('display', 'none');
           $("#ad_wallet_form_action_"+method).css('display', 'block')
        });
    </script>

@endsection
