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
                    <form method="post" action="{{route('advert.edit', ['lang' => app()->getLocale(), 'id' => $item['ad_id']])}}" enctype="multipart/form-data">
                        @csrf
                        @include('flash-message')
                        <div class="form-group">
                            <label class="form-label" for="campaign">Kampaniya</label>
                            <div class="form-select">
                                <select class="select-ns" name="campaign_id" id="campaign" disabled>
                                    @foreach($campaigns as $c)
                                        <option value="{{$c['campaign_id']}}" @if($c['campaign_id'] == $item['campaign_id']) selected @endif>{{$c['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="group">Qrup</label>
                            <div class="form-select">
                                <select class="select-ns" name="set_id" id="group" disabled>
                                    @foreach($groups as $c)
                                        <option value="{{$c['set_id']}}" @if($c['set_id'] == $item['set_id']) selected @endif>{{$c['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="w-format">Reklamın formatı</label>
                            <div class="form-select">
                                <select class="select-ns" name="format" id="w-format">
                                    <option value="10" {{selected("10", $item['format_type_id'])}}>Kod</option>
                                    <option value="11" {{selected("11", $item['format_type_id'])}}>Görüntülü reklamlar (.jpg, .GİF)</option>
                                    <option value="12" {{selected("12", $item['format_type_id'])}} selected="selected">Xəbər</option>
                                    <option value="15" {{selected("15", $item['format_type_id'])}}>Sticky vertical ads</option>
                                    <option value="79" {{selected("79", $item['format_type_id'])}}>Animasiyalı banner (HTML5)</option>
                                    <option value="83" {{selected("83", $item['format_type_id'])}}>Catfish</option>
                                    <option value="260" {{selected("260", $item['format_type_id'])}}>Interscroller</option>
                                    <option value="261" {{selected("261", $item['format_type_id'])}}>InPage / Pre-roll</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" id="adJsnamelabel">Xəbər başlığı</label>
                            <div class="form-input">
                                <input value='{{$item['name']}}' placeholder="{{__('adnetwork.name')}}" name="name" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="url">Hədəf URL</label>
                            <div class="form-input">
                                <input id="url" value='{{$item['ad_url']}}' placeholder="{{__('adnetwork.target_url')}}" name="target_url" type="text">
                            </div>
                        </div>


                        <div class="form-group d-none" id="adJsdimension_id">
                            <label class="form-label">Ölçü</label>
                            <div class="form-select">
                                <select class="select-ns" name="dimension_id">
                                    <option value="3" {{selected("3", $item['dimension_id'])}}>728x90</option>
                                    <option value="5" {{selected("5", $item['dimension_id'])}}>320x100</option>
                                    <option value="6" {{selected("6", $item['dimension_id'])}}>300x600</option>
                                    <option value="7" {{selected("7", $item['dimension_id'])}}>300x250</option>
                                    <option value="12" {{selected("12", $item['dimension_id'])}}>468x60</option>
                                    <option value="16" {{selected("16", $item['dimension_id'])}}>240x400</option>
                                    <option value="17" {{selected("17", $item['dimension_id'])}}>160x600</option>
                                    <option value="30" {{selected("30", $item['dimension_id'])}}>1x1</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group d-none" id="adJstext">
                            <label class="form-label">Reklam kodu</label>
                            <div class="form-input">
                                <textarea placeholder="Reklam kodu" name="text">{{$item['text']}}</textarea>
                            </div>
                        </div>

                        <div class="form-group d-none" id="adJsdisplay_name">
                            <label class="form-label">Domenin görünən adı</label>
                            <div class="form-input">
                                <input placeholder="Domenin görünən adı" type="text" name="display_name" value="{{$item['display_name']}}">
                            </div>
                        </div>

                        <div class="form-group d-none" id="adJsqqfile">
                            <label class="form-label">File Manager</label>
                            <div class="form-input">
{{--                                <input type="file" name="file" value="{{json_decode($item['file_data'])->dir_url}}" data-files="['{{json_decode($item['file_data'])->dir_url}}']"/>--}}
                                <div class="c-field">
                                    <input name="file" type="text" class="filepond" @if($item['file_data'] != null) value="{{json_decode($item['file_data'])->dir_url}}" @endif   />
                                    <input type="hidden" @if($item['file_data'] != null) value="{{json_decode($item['file_data'])->dir_url}}" @endif name="ads_file" id="ads_file" >


                                    @if($item['file_data'] != null)
                                        @php $file = json_decode($item['file_data']) @endphp

                                        @if(str_contains($file->type, "image"))
                                            <img src="{{$file->dir_url}}" alt="" id="filepond_file" style="max-width: 100%; max-height: 100%">
                                        @elseif(str_contains($file->type, "video"))

                                            <video width="400" controls  id="filepond_file" style="width: 100%">
                                                <source src="{{$file->dir_url}}" type="video/mp4">
                                                <source src="{{$file->dir_url}}" type="video/ogg">
                                            </video>
                                        @endif

                                        @if($file->type != null)
                                        <div class="file-delete">
                                            <button class="file-delete">Delete</button>
                                        </div>
                                        @endif

                                    @endif


{{--                                            <img src="{{json_decode($item['file_data'])->dir_url}}" id="gal{{json_decode($item['file_data'])->dir_url}}">--}}
                                </div>



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
                                    <option value="1" {{selected("1", $item['model_id'])}}>CPC</option>
                                    <option value="2" {{selected("2", $item['model_id'])}}>CPM</option>
                                    <option value="3" {{selected("3", $item['model_id'])}}>CPV</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="budce">Büdcə səviyyəsi</label>
                            <div class="form-select">
                                <select class="select-ns" name="budget_level" id="budce">
                                    <option value="1" {{selected("1", $item['budget_level'])}}>Reklam qrupu səviyyəsi</option>
                                    <option value="2" {{selected("2", $item['budget_level'])}}>Bu reklam kreativi üçün ayrıca büdcə</option>
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
                                                <option value="1"  {{selected("1", $item['budget_type'])}}>Günlük</option>
                                                <option value="2"  {{selected("2", $item['budget_type'])}}>Toplam ümumi</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-item col-a mxw-250">
                                        <div class="form-input d-block">
                                            <input id="budget_planned" value='{{$item['budget_planned']}}' name="budget_planned" type="number">
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
                                                <input value="{{$item['unit_cost_min']}}" type="text" name="unit_cost_min">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-item col-b">
                                        <div class="form-input d-block in-left">
                                            <span class="in-group">Max qiymət</span>
                                            <div class="in-input">
                                                <input value="{{$item['unit_cost_max']}}" type="text" name="unit_cost_max">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group d-block">
                            <div class="form-select mt-30 d-block">
                                <select class="select-ns" name="targeting" id="targeting">
                                    <option value="0" @if(count($s_sites) == 0 and count($excludeds) == 0 and $item['targeting']['frequency'] == 0) selected  @endif>Bütün hədəflər (tövsiyə olunan variant)</option>
                                    <option value="1" @if(count($s_sites) != 0 or count($excludeds) != 0 or $item['targeting']['frequency'] == 1) selected  @endif>Məhdud paylanma</option>
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
                                            @foreach($s_sites as $site)
                                                <option value="{{$site['site_id']}}" selected>{{$site['domain']}}</option>
                                            @endforeach
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
                                            @foreach($excludeds as $site)
                                                <option value="{{$site['site_id']}}" selected>{{$site['domain']}}</option>
                                            @endforeach
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
                                            <input id="status" name="frequency" value="1" type="checkbox" @if($item['targeting']['frequency'] == 1) checked @endif>
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
                                    <option value="0" {{selected("0", $item['accelerated'])}}>Bəli</option>
                                    <option value="1" {{selected("1", $item['accelerated'])}}>Yox</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="no_earning">Qazandırır</label>
                            <div class="form-select">
                                <select class="select-ns" name="no_earning" id="no_earning">
                                    <option value="0" {{selected("0", $item['no_earning'])}}>Qazandırmır</option>
                                    <option value="1" {{selected("1", $item['no_earning'])}}>Qazandırır</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="no_spent">Büdcədən xərclənməsin</label>
                            <div class="form-select">
                                <select class="select-ns" name="no_spent" id="no_spent">
                                    <option value="0"  {{selected("0", $item['no_spent'])}}>Xərclənməsin</option>
                                    <option value="1"  {{selected("1", $item['no_spent'])}}>Xərclənsin</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="ruser">Ref User</label>
                            <div class="form-input">
                                <input id="ruser" value='{{$item['ref_user_id']}}' type="text" name="ref_user_id">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="ruserf">Ref User faiz</label>
                            <div class="form-input">
                                <input id="ruserf" value='{{$item['ref_share_rate']}}' type="text" name="ref_share_rate">
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

        const inputElement = document.querySelector('input.filepond');
        const pond = FilePond.create(inputElement, {
            allowDownloadByUrl: true,
            labelButtonDownloadItem: 'custom label',
            onaddfilestart: (file) => { isLoadingCheck(); },
            onprocessfile: (files) => { isLoadingCheck(); },

        });

        $(".file-delete").click(function (){
           $("#filepond_file").remove();
           $("input[name='file']").val('');
           $("#ads_file").val('');
           $(this).remove()
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
                            $("#filepond_file").remove()
                            $("div.file-delete").remove()
                            $("#ads_file").val(request.responseText)
                            console.log(request.responseText)
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
                revert:(fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                    $("#ads_file").val('');
                    $("input[name='file']").val('');
                },
                // revert: '/az/advert/files/delete',
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
