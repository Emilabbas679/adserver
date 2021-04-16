@extends('layouts.app')
@section('title', 'Translations')
@section('content')
    @csrf

    <style>
        .translate-page {}
        .translate-page .translate-top {margin-bottom:15px;}
        .translate-top .dropdown, .translate-top .a-button.with-icon {float:left; margin-right:15px; display:block;}
        .tr-text {font-size: 16px; line-height: 24px; font-weight: 500; color: #868686; margin-bottom:10px;}
    </style>

    <div class="content-wrapper">
        <div class="container">
            <!-- Main content -->
            <section class="content translate-page">
                <div class="content-inner">
                    <div class="breadcrumb">
                        <ul>
                            <li><a href="/">Adserver</a></li>
                            <li><span>Translate</span></li>
                        </ul>
                    </div>
                    <div class="a-block">
                        <div class="a-block-head">Tərcümənin idarə edilməsi</div>
                        <div class="a-block-body">
                            @include('flash-message')
                            <div class="translate-top">
                                <div class="dropdown">
                                    <div class="d-button">{{$file}}</div>
                                    <div class="dropdown-menu">
                                        <ul>
                                            @foreach($files as $f)
                                                <?php if ($f == $file) continue; ?>
                                                <li><a class="dropdown-item"
                                                       href="{{url('/'.app()->getLocale().'/translate?file='.$f)}}">{{$f}}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <button type="button" class="b-scn a-button with-icon add" onclick="cloneRow()">Sətir əlavə et</button>
                                <button type="button" class="b-scn a-button with-icon addfile mbtn" data-target="#fileCreateModal">Fayl əlavə et</button>
{{--                                <button type="button" class="b-green a-button f-right" onclick="$('#form').submit()">Yadda saxla</button>--}}
                                <a class="b-green a-button f-right" href="{{route('translation_update_cron', app()->getLocale())}}">Yenilə</a>
                            </div>
                            <form action method="post" id="form">
                                @csrf
                                <div class="table-responsive">
                                    <table class="table table-fixed">
                                        <thead>
                                        <tr>
                                            <th>key</th>
                                            <th>Azərbaycanca</th>
                                            <th>English</th>
                                            <th>Русский</th>
                                            <th class="w-100">Sil</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php unset($languages[config('app.fallback_locale')]); ?>
                                        @foreach($lang[config('app.fallback_locale')] as $key => $value)
                                            <tr id="{{$key}}">
                                                <td><textarea class="x-textarea" name="key[]" readonly>{{$key}}</textarea></td>
                                                <td><textarea class="x-textarea" readonly name="{{config('app.fallback_locale')}}[]">{{$value}}</textarea></td>
                                                @foreach ($languages as $k => $v)
                                                    @if(isset($lang[$k][$key]))
                                                        <td><textarea class="x-textarea" name="{{$k}}[]" readonly>{{$lang[$k][$key]}}</textarea></td>
                                                    @else
                                                        <td><textarea class="x-textarea" name="{{$k}}[]" readonly></textarea></td>
                                                    @endif
                                                @endforeach
                                                <td><button type="button" class="del bt-icon b-red trash m-center" data-key="{{$key}}"></button></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div id="fileCreateModal" class="modal">
                    <div class="modal-wrap">
                        <div class="modal-content">
                            <div class="modal-a w-600">
                                <div class="modal-header">
                                    <h2 class="md-title">Tərcümə faylının yaradılması</h2>
                                    <div class="x-close"></div>
                                </div>
                                <div class="modal-body">
                                    <div class="tr-text">Please use only file name not extension (ex. use general not general.php)</div>
                                    <form id="formInput" method="post" action="{{route('translate_create', app()->getLocale())}}">
                                        @csrf
                                        <input type="text" name="filename" class="x-input" id="filename" required />
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="b-green a-button f-right" onClick="return sendModalCreateFile();">Faylı yarat</button>
                                </div>
                                <script>
                                    function sendModalCreateFile(e) {
                                        if(document.getElementById('filename').value !== '') {
                                            document.getElementById('formInput').submit();
                                            return true;
                                        } else {
                                            $('#filename').focus()
                                            alert("Filename needed");
                                            return false;
                                        }
                                    }
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <script>
        //var DataTable = $('#items').DataTable({paging: false});
        function cloneRow() {
            var row = $('tbody tr:first').clone();

            row.find("textarea").val("");
            row.find("textarea").removeAttr("readonly");
            $("tbody").prepend(row);
        }

        $('button.del').click(function(){
            let key = $(this).attr('data-key');
            $("tr#"+key).remove()
        })
    </script>
@endsection
