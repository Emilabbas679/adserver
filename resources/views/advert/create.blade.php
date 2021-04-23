@extends('layouts.app')
@section('title', )
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
            <div class="a-block-head">Reklama düzəliş et</div>
            <div class="a-block-body">
                <div class="form form-horizontal">
                    <form method="post" action="{{route('advert.create', ['lang' => app()->getLocale()])}}" enctype="multipart/form-data">
                        @csrf
                        @include('flash-message')
                        <div class="form-group">
                            <label class="form-label" for="campaign">Kampaniya</label>
                            <div class="form-select">
                                <select class="select-ns" name="campaign_id" id="campaign">
                                    @foreach($campaigns as $c)
                                        <option value="{{$c['campaign_id']}}" {{selected(old('campaign_id'), $c['campaign_id'])}}>{{$c['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="group">Qrup</label>
                            <div class="form-select">
                                <select class="select-ns" name="set_id" id="group">
                                    @foreach($groups as $c)
                                        <option value="{{$c['set_id']}}" {{selected(old('set_id'), $c['set_id'])}}>{{$c['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="w-format">Reklamın formatı</label>
                            <div class="form-select">
                                <select class="select-ns" name="format" id="w-format">
                                    <option value="10" {{selected(old('format'), 10)}}>Kod</option>
                                    <option value="11" {{selected(old('format'), 11)}}>Görüntülü reklamlar (.jpg, .GİF)</option>
                                    <option value="12" {{selected(old('format'), 12)}}>Xəbər</option>
                                    <option value="15" {{selected(old('format'), 15)}}>Sticky vertical ads</option>
                                    <option value="79" {{selected(old('format'),79)}}>Animasiyalı banner (HTML5)</option>
                                    <option value="83" {{selected(old('format'), 83)}}>Catfish</option>
                                    <option value="260" {{selected(old('format'),260)}}>Interscroller</option>
                                    <option value="261" {{selected(old('format'), 261)}}>InPage / Pre-roll</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" id="adJsnamelabel">Xəbər başlığı</label>
                            <div class="form-input">
                                <input value='{{old('name')}}' placeholder="{{__('adnetwork.name')}}" name="name" type="text">
                                @error('name')
                                <div class="notification-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="url">Hədəf URL</label>
                            <div class="form-input">
                                <input id="url" value='{{old('target_url')}}' placeholder="{{__('adnetwork.target_url')}}" name="target_url" type="text">
                                @error('target_url')
                                <div class="notification-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group d-none" id="adJsdimension_id">
                            <label class="form-label">Ölçü</label>
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
                            <label class="form-label">Reklam kodu</label>
                            <div class="form-input">
                                <textarea placeholder="Reklam kodu" name="text">{{old('text')}}</textarea>
                            </div>
                        </div>

                        <div class="form-group d-none" id="adJsdisplay_name">
                            <label class="form-label">Domenin görünən adı</label>
                            <div class="form-input">
                                <input placeholder="Domenin görünən adı" type="text" name="display_name" value="{{old('display_name')}}">
                            </div>
                        </div>

                        <div class="form-group d-none" id="adJsqqfile">
                            <label class="form-label">File Manager</label>
                            <div class="form-input">
                                <input type="file" name="file"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Model
                                <i class="popover">
									<span>
										<p><b>CPM</b> -reklamı hər 1000 göstərimə görə qiymət</p>
										<p><b>CPC</b> - hər klikə görə qiymət</p>
										<p><b>CPV</b> - video-reklama baxmağa görə qiymət</p>
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
                            <label class="form-label" for="budce">Büdcə səviyyəsi</label>
                            <div class="form-select">
                                <select class="select-ns" name="budget_level" id="budce">
                                    <option value="1"  {{selected(old('budget_level'), 1)}}>Reklam qrupu səviyyəsi</option>
                                    <option value="2"  {{selected(old('budget_level'), 2)}}>Bu reklam kreativi üçün ayrıca büdcə</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="budget_type">Büdcə tipi</label>
                            <div class="f-tbl">
                                <div class="cols">
                                    <div class="col-item col-a mxw-250">
                                        <div class="form-select d-block">
                                            <select class="select-ns" name="budget_type" id="budget_type">
                                                <option value="1"  {{selected(old('budget_type'), 1)}}>Günlük</option>
                                                <option value="2"  {{selected(old('budget_type'), 2)}}>Toplam ümumi</option>
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
                            <label class="form-label">Bid
                                <i class="popover">
									<span>
										<p><b>Aşağı stavka</b> - reklamınızın görünmə ehtimalı azalır</p>
										<p><b>Yuxarı stavka</b> - reklamınızın görünmə ehtimalı artır</p>
									</span>
                                </i>
                            </label>
                            <div class="f-tbl">
                                <div class="cols">
                                    <div class="col-item col-b">
                                        <div class="form-input d-block in-left">
                                            <span class="in-group">Min qiymət</span>
                                            <div class="in-input">
                                                <input @if(old('unit_cost_min')) value="{{old('unit_cost_min')}}" @else value="0" @endif type="text" name="unit_cost_min">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-item col-b">
                                        <div class="form-input d-block in-left">
                                            <span class="in-group">Max qiymət</span>
                                            <div class="in-input">
                                                <input type="text" name="unit_cost_max" @if(old('unit_cost_max')) value="{{old('unit_cost_max')}}" @else value="0" @endif >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group d-block">
                            <div class="form-select mt-30 d-block">
                                <select class="select-ns" name="targeting" id="targeting">
                                    <option value="0" selected="selected">Bütün hədəflər (tövsiyə olunan variant)</option>
                                    <option value="1">Məhdud paylanma</option>
                                </select>
                            </div>
                        </div>

                        <div class="h-block">
                            <div class="alert alert-info">
                                <button type="button" class="a-close"></button>
                                <strong>Nəzərə alın ki, hədəfləmələri çox qoyub auditoriyanı daraltsanız, reklamınızı daha az adam görəcək.</strong>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Yayımlamaq istədiyiniz saytlar
                                    <i class="popover">
										<span>
											<p>Siz reklamınızı yalnız seçdiyiniz saytlarda göstərə bilərsiniz. Bu zaman başqa saytlarda deyil, məhz seçdiyiniz saytlarda reklam görünəcək.</p>
											<p>Bu funksiyadan istifadə reklamın qiymətini qaldıra bilər.</p>
										</span>
                                    </i>
                                </label>
                                <div class="f-tbl">
                                    <div class="form-select d-block">
                                        <select class="select-tag sites" name="sites[]" multiple="multiple" style="width: 100%">

                                        </select>
                                    </div>
                                    <span class="badge badge-z mt-5 mbtn" data-target="#websites">Saytların siyahısı</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Qadağan olunmuş saytlar
                                    <i class="popover">
										<span>
											<p>Reklamınızın bəzi saytlarda yayımlanmasını bloklaya və bununla reklamınzı daha dar auditoriyaya göstərə bilərsiniz.</p>
											<p>Qeyd: bu funksiyadan istifadə reklamın qiymətini qaldıra bilər.</p>
										</span>
                                    </i>
                                </label>
                                <div class="f-tbl">
                                    <div class="form-select d-block">
                                        <select class="select-tag sites" multiple="multiple" name="forbidden_sites[]" style="width: 100%">

                                        </select>
                                    </div>
                                    <span class="badge badge-z mt-5 mbtn" data-target="#websites">Saytların siyahısı</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Göstərmə tezliyinə limit (Frequency capping)
                                    <i class="popover">
										<span>
											<p>Bir unikal istifadəçiyə reklamın maksimum göstərilmə sayı</p>
											<p>Tezlik nə qədər az olsa, eyni adam reklamı o qədər də az görəcək.</p>
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
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <label class="form-label" for="accelerated">Sürətləndir</label>
                            <div class="form-select">
                                <select class="select-ns" name="accelerated" id="accelerated">
                                    <option value="0" {{selected(old('accelerated'), 0)}}>Bəli</option>
                                    <option value="1"  {{selected(old('accelerated'), 1)}}>Yox</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="no_earning">Qazandırır</label>
                            <div class="form-select">
                                <select class="select-ns" name="no_earning" id="no_earning">
                                    <option value="0"  {{selected(old('no_earning'), 0)}}>Qazandırmır</option>
                                    <option value="1"  {{selected(old('no_earning'), 1)}}>Qazandırır</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="no_spent">Büdcədən xərclənməsin</label>
                            <div class="form-select">
                                <select class="select-ns" name="no_spent" id="no_spent">
                                    <option value="0" {{selected(old('no_spent'), 0)}}>Xərclənməsin</option>
                                    <option value="1" {{selected(old('no_spent'), 1)}}>Xərclənsin</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="ruser">Ref User</label>
                            <div class="form-input">
                                <input id="ruser"  @if(old('ref_user_id')) value="{{old('ref_user_id')}}" @else value="0" @endif  type="number" max="1" min="0" step="0.1" name="ref_user_id">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="ruserf">Ref User faiz</label>
                            <div class="form-input">
                                <input id="ruserf" @if(old('ref_share_rate')) value="{{old('ref_share_rate')}}" @else value="0" @endif type="number" max="1"  min="0" step="0.1" name="ref_share_rate">
                            </div>
                        </div>


                        <div class="t-center">
                            <button class="a-button b-green" type="submit">{{__('admin.submit')}}</button>
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
                        <h2 class="md-title">Vebsaytlar</h2>
                        <div class="x-close"></div>
                    </div>
                    <div class="modal-body">
                        <div class="ws-list">
                            <ul>
                                <li class="ws-head">
                                    <span class="w-id">ID</span><span class="w-name">Saytın adı</span>
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

    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="/filepond/dist/filepond-plugin-media-preview.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">



@endsection
@section('js')

    <script>
        $(document).ready(function() {
            $('select.sites').select2({
                placeholder: "{{__('placeholders.site_domain')}}",
                language: {
                    searching: function () {
                        return "{{__('placeholders.searching')}}";
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/filepond/4.27.0/filepond.min.js" integrity="sha512-xqJsP8aZZAF5zkXmst5/KF7jXO9q9F1JFH/RGUa1hDjLUx6v6Nl9TpbfVAiFuAHCyZFkUrqHyvG/EODv0QEM8w==" crossorigin="anonymous"></script>
    <script>
        $('#w-format').on('change',function() {
            if($(this).val() == 12){
                $('#adJsnamelabel').text('Xəbər başlığı');
            } else {
                $('#adJsnamelabel').text('Reklam kreativinin adı');
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
