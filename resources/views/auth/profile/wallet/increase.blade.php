@extends('layouts.app')
@section('title', __('adnetwork.wallet_increase'))
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
                <div class="form form-horizontal">
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
                            <label class="form-label" for="phone">{{__('adnetwork.tel')}}</label>
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
                                <select name="action_id" id="method" class="select-ns">
                                    <option value="41" selected="selected">{{__('adnetwork.bank_card')}}</option>
                                    <option value="31">{{__('adnetwork.cash')}}</option>
                                    <option value="32">{{__('adnetwork.bank_transfer')}}</option>
                                    <option value="22">{{__('adnetwork.bank_transfer')}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group d-none" id="cardTypeBlock">

                            <div class="form-group">
                                <label class="form-label" for="bankType">{{__('adnetwork.bankType')}}</label>
                                <div class="form-select">
                                    <select name="bankType" id="bankType" class="select-ns">
                                        <option value="0">Paşa bank</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="cardType">{{__('adnetwork.cardType')}}</label>
                                <div class="form-select">
                                    <select name="cardType" id="cardType" class="select-ns">
                                        <option value="0">Visa</option>
                                        <option value="1">Mastercard</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="walletinfo" id="ad_wallet_form_action_31">
                            <div class="wl-top">Nağd ödəniş</div>
                            <div class="wl-body">
                                <p>Adminstrasiya ilə əlaqə saxlayın</p>
                                <p>Tel: 055 204 62 44</p>
                            </div>
                        </div>

                        <div class="walletinfo" id="ad_wallet_form_action_32">
                            <div class="wl-top">Bank köçürmə</div>
                            <div class="wl-body">
                                <p>
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
                                </p>
                            </div>
                        </div>

                        <div class="walletinfo" id="ad_wallet_form_action_22">
                            <div class="wl-top">Admin ödəniş paneli</div>
                            <div class="wl-body">
                                <p>Admin tərəfindən ödəniş olunduqda heç ödəniş nəğd şəkildə şirkət tərəfindən alınmalıdır.</p>
                            </div>
                        </div>

                        <div class="walletinfo" id="ad_wallet_form_action_41">
                            <div class="wl-top">Online ödəniş</div>
                            <div class="wl-body">
                                <p>Əməliyyat "Bank of Baku"nun prosessinq mərkəzi vasitəsi ilə həyata keçirilir.</p>
                            </div>
                        </div>

                        <div class="t-center mt-20">
                            <button class="a-button b-green" type="submit">{{__('adnetwork.submit')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('css')
    <style>
        .walletinfo {display:none; border-radius:5px; border:1px solid #ffe4cc;}
        .walletinfo .wl-top {background-color: #ffe4cc; padding: 10px 15px; font-size: 15px; line-height: 18px; font-weight: bold; letter-spacing: 0.5px;}
        .walletinfo .wl-body {padding: 10px 15px; font-size:14px; line-height:20px;}
        .form-horizontal .form-group.d-none {display:none;}
    </style>
@endsection
@section('js')
    <script>
        $("#method").change(function (){
            let method = $(this).val();
            if (method == 41) {
                $("#cardTypeBlock").slideDown(300);
            }
            else{
                $("#cardTypeBlock").slideUp(300);
            }
            $(".walletinfo").slideUp(300);
            $("#ad_wallet_form_action_"+method).slideDown(300);
        });
        $("#method").trigger('change');
    </script>

@endsection
