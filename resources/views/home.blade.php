@extends('layouts.app')
@section('title', env('APP_NAME'))
@section('content')
    <div class="content-inner">
        <div class="breadcrumb">
            <ul>
                <li><a href="{{route('home')}}">Smartbee</a></li>
                <li><span>İdarə paneli</span></li>
            </ul>
        </div>
        <!-- Cards start -->
        @include('partials.cards')
        @include('flash-message')
        <!-- Cards end -->
        <div class="cols">
            <div class="col-item col-a">
                <div class="a-block">
                    <div class="a-block-head">Reklam elanları</div>
                    <div class="a-block-body">

                    </div>
                </div>
            </div>
            <div class="col-item col-a">
                <div class="a-block">
                    <div class="a-block-head">Form elements</div>
                    <div class="a-block-body">
                        <div class="form">
                            <form>
                                <div class="form-group">
                                    <label class="form-label" for="testinput">E-mail</label>
                                    <div class="form-input">
                                        <input id="textinput" type="text" placeholder="E-mail daxil edin">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="testinput2">E-mail</label>
                                    <div class="form-input">
                                        <input id="textinput2" type="text" placeholder="E-mail daxil edin">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="testinput3">Password</label>
                                    <div class="form-input">
                                        <input id="textinput3" type="password" placeholder="Şifrəni daxil edin">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="testtext">Ətraflı məlumat</label>
                                    <div class="form-input">
                                        <textarea id="testtext" placeholder="Məlumat daxil edin"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="testtext">Ölkə</label>
                                    <div class="form-select">
                                        <select name="country" id="country" class="select-ns" data-placeholder="Ölkə seçin">
                                            <option value="">Ölkə seçin</option>
                                            <option value="Afganistan">Afghanistan</option>
                                            <option value="Albania">Albania</option>
                                            <option value="Algeria">Algeria</option>
                                            <option value="American Samoa">American Samoa</option>
                                            <option value="Andorra">Andorra</option>
                                            <option value="Angola">Angola</option>
                                            <option value="Anguilla">Anguilla</option>
                                            <option value="Antigua &amp; Barbuda">Antigua &amp; Barbuda</option>
                                            <option value="Argentina">Argentina</option>
                                            <option value="Aruba">Aruba</option>
                                            <option value="Australia">Australia</option>
                                            <option value="Austria">Austria</option>
                                            <option value="Azerbaijan">Azerbaijan</option>
                                            <option value="Bahamas">Bahamas</option>
                                            <option value="Bahrain">Bahrain</option>
                                            <option value="Bangladesh">Bangladesh</option>
                                            <option value="Barbados">Barbados</option>
                                            <option value="Belarus">Belarus</option>
                                            <option value="Belgium">Belgium</option>
                                            <option value="Belize">Belize</option>
                                            <option value="Benin">Benin</option>
                                            <option value="Bermuda">Bermuda</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                            <div style="height:100px"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
