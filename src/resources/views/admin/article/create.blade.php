@extends('layouts.admin')
@section('content')
<form action="{{route('administrator.article.create')}}" method="post" enctype="multipart/form-data">
    @csrf
<div class="card text-black">

    <div class="card-header d-inline-flex justify-content-between bg-success text-white edit-article-card-header align-items-center">
        <div class="title_headbar">{{ $title }}</div>
        <div class="function_button">
            <button class="btn btn-success" type="submit" name="btn" value="zapisz">Zapisz</button>
            <button class="btn btn-success" type="submit" name="btn" value="zapisz-i-zamknij">Zapisz i zamknij</a>
            {{-- <button class="btn btn-success" type="submit" name="btn" value="zapisz-i-nowy">Zapisz i nowy</a> --}}
            <button class="btn btn-success" type="submit" name="btn" value="zamknij">Zamknij</a>
        </div>
    </div>
    <div class="col-12">
        @if ($errors->any())
            <div class="alert alert-danger mb-0 mt-3">
                <ul class="m-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
    <div class="d-flex align-items-center form-group edit-title mt-3 mx-1">
        <div class="col-6 d-flex pl-0 align-items-center">
            <label class="p-2 mb-0">Tytuł:</label>
            <input id="jform_title" class="form-control" type="text" name="title" value="{{ old('title') }}"/>
        </div>
    </div>
    <div class="d-inline-flex edit-content pb-5">
        <div class="card-body p-0 col-9">
            <div class="card">
                <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" id="bologna-list" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" href="#tresc" role="tab" aria-controls="description" aria-selected="true">Treść</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"  href="#zdjecia" role="tab" aria-controls="image" aria-selected="false">Zdjęcia</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#opcje_publikacji" role="tab" aria-controls="other" aria-selected="false">Opcje publikacji</a>
                    </li>
                    @if(Auth::user()->CheckAccessForAccesTo('kafelki'))
                    <li class="nav-item">
                        <a class="nav-link" href="#cards" role="tab" aria-controls="cards" aria-selected="false">Kafelki</a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="#seo" role="tab">SEO
                            <span id="route66-seo-score-badge" class="badge"></span>
                        </a>
                    </li>
                </ul>
                </div>
                <div class="card-body">
                <div class="tab-content mt-3">
                    <div class="tab-pane active" id="tresc" role="tabpanel">
                        {{-- <textarea id="mytextarea" class="tinywithimg" style="width: 100%; min-height: 500px;" name="fulltext"></textarea> --}}
                        <textarea id="ce" class="form-control" name="fulltext">{{ old('fulltext') }}</textarea>
                        {{-- <textarea name="tresc" id="editor" class="editor"></textarea> --}}
                    </div>
                    <div class="tab-pane" id="zdjecia" role="tabpanel" aria-labelledby="image-tab">
                        <div class="input-group flex-column mb-3 col-12">
                            <label class="mb-0 mt-2">Artykuł bez ilustracji</label>
                            <div class="btn-group btn-group-yesno radio col-9 pl-0" style="max-width: 300px;">
                                <input id="toggle-on" name="image_not_required" class="yesornot " value='1' type="radio">
                                <label for="toggle-on" class="yesornot btn" id="yes">Tak</label>
                                <input id="toggle-off" name="image_not_required" class="yesornot" value='0' checked type="radio">
                                <label for="toggle-off" class="yesornot btn" id="no">Nie</label>
                            </div>
                        </div>
                        <div class="" id="image_upload_box">
                            <div class="form-group col-12">
                                <label for="photo">Ilustracja wprowadzenia <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-white">
                                        <i class="fa fa-picture-o"></i> Wybierz
                                        </a>
                                    </span>
                                    <input id="thumbnail" class="form-control" type="text" name="image_intro" value="{{old('image_intro') ?? ''}}">
                                </div>
                                <div id="holder" style="margin-top:15px;max-height:100px;"></div>
                                {{-- <div class="custom-file">
                                    <input type="file" name="image_intro" id="photo" class="custom-file-input">
                                    <label for="photo" class="custom-file-label">Wybierz plik</label>
                                </div> --}}
                            </div>
                            <div class="form-group col-12">
                                <label for="photo_alt">Tekst alternatywny obrazka <span class="text-danger">*</span></label>
                                <input type="text" name="image_intro_alt" id="photo_alt" class="form-control" placeholder="Tekst alternatywny do zdjecia" value="{{ old('image_intro_alt') }}">
                            </div>
                            <hr />
                        </div>
                        <div class="control-group mb-3 d-flex align-items-center col-12">
                            <label for="link" class="col-2 pl-0">Url filmu</label>
                            <input type="text" name="link" id="link" class="form-control col-10" placeholder="Link do filmu" value="{{ old('link') }}">
                        </div>
                         <div class="control-group mb-3 d-flex col-12">
                            <label for="zrodlo" class="col-2 pl-0">Źródło</label>
                            <select class="custom-select flex-column col-10" name="zrodlo">
                                <option value="">Brak</option>
                                <option value="youtube">Youtube</option>
                                {{-- <option value="facebook">Facebook</option> --}}
                            </select>
                        </div>
                    </div>
                    <div class="tab-pane" id="opcje_publikacji" role="tabpanel" aria-labelledby="other-tab">
                        <div class="input-group mb-3 d-flex align-items-center">
                            <label class="col-3" for="publish_up">Data rozpoczęcia publikacji:</label>
                            <input class="col-4 form-control" type="datetime-local" id="publish_up" name="publish_up" value="">
                        </div>
                        <div class="input-group mb-3 d-flex align-items-center">
                            <label class="col-3" for="autor">Autor</label>
                            <select class="custom-select col-4" id="autor" name="created_by">
                                @foreach ($authors as $key => $author)
                                    @if ($author->id == Auth::id())
                                        <option selected value="{{ $author->id }}">{{ $author->name }}</option>
                                    @else
                                        <option value="{{ $author->id }}">{{ $author->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="input-group mb-3 d-flex align-items-center">
                            <label class="col-3">Etykieta</label>
                            <select class="custom-select col-4" name="etykieta">
                                <option value=""></option>
                                @foreach (\App\Models\Content::ARTICLE_LABELS as $key => $etykieta)
                                    <option {{ (old('etykieta') == $key) ? 'selected' : '' }} value="{{ $key }}">{{ $etykieta }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="tab-pane" id="cards" role="tabpanel" aria-labelledby="cards-tab">
                        <div class="input-group mb-3 d-flex align-items-center ">
                            <label for="has_position" class="col-4 m-0">Czy artykuł ma mieć wybrana pozycje?</label>
                            <input type="checkbox" value="yes" name="col-4 has_position" class="has_position" id="has_position" onchange="valueChanged()" data-toggle="toggle" data-onstyle="success" data-on="Tak" data-off="Nie">
                        </div>
                        <div class="pozycjakafelka">
                            <label class="col-3">Pozycja:</label>
                            <select class="custom-select col-4" name="position">
                                @for($i = 1; $i < 9; $i++)
                                    <option value="{{$i}}">{{'Kafelek '.$i}}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="tab-pane" id="seo" role="tabpanel" aria-labelledby="other-tab">
                        @include('admin._modules.plugin_seo')
                    </div>
                </div>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="control-group mb-3">
                <label for="stan" class="m-0">Stan</label>
                <select class="custom-select custom-select-sm flex-column" name="state">
                    <option selected value="1">Opublikowane</option>
                    <option value="0">Nie opublikowane</option>
                    <option value="2">Zarchiwizowane</option>
                    <option value="-2">W koszu</option>
                </select>
            </div>
            <div class="control-group mb-3">
                <label for="category">Kategoria główna</label>
                <select class="custom-select custom-select-sm flex-column" id="category" name="catid">
                    @foreach ($main_category as $key => $category)
                        <option value="{{ $category->id }}">- {{ $category->title }}</option>
                        @if(isset($secoundary_category[$category->id]))
                            @foreach ($secoundary_category[$category->id] as $key => $category_lv2)
                                <option value="{{ $category_lv2->id }}">&nbsp;&nbsp;|-- {{ $category_lv2->title }}</option>
                            @endforeach
                        @endif
                    @endforeach
                    <option style="color:orange;" value="16">- STRONY</option>
                </select>
            </div>
            <div class="control-group d-flex flex-column mb-3">
                Inne kategorie
                <select class="selectpicker" name="category_content[]" id="categories" multiple data-live-search="true">
                    @foreach ($main_category as $key => $category)
                        <option value="{{ $category->id }}" data-alias="{{ $category->alias }}">- {{ $category->title }}</option>
                        @if(isset($secoundary_category[$category->id]))
                            @foreach ($secoundary_category[$category->id] as $key => $category_lv2)
                                <option value="{{ $category_lv2->id }}" data-alias="{{ $category->alias }}/{{ $category_lv2->alias }}">&nbsp;&nbsp;|-- {{ $category_lv2->title }}</option>
                            @endforeach
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="input-group flex-column">
                <label class="mb-0 mt-2">Wyróżnione</label>
                <div class="btn-group btn-group-yesno-wyroznione radio col-9 pl-0">
                    <input id="featured-on" name="featured" class="yesornot " value='1' type="radio">
                    <label for="featured-on" class="yesornot btn" id="yes">Tak</label>
                    <input id="featured-off" name="featured" class="yesornot" value='0' checked type="radio">
                    <label for="featured-off" class="yesornot btn" id="no">Nie</label>
                </div>
            </div>
            <div class="input-group flex-column">
                <label class="mb-0 mt-2">Wyświetl jako PILNE</label>
                <div class="btn-group btn-group-yesno-pilne radio col-9 pl-0">
                    <input id="pilne-on" name="type" class="yesornot " value='pilne' type="radio">
                    <label for="pilne-on" class="yesornot btn" id="yes">Tak</label>
                    <input id="pilne-off" name="type" class="yesornot" value='0' checked type="radio">
                    <label for="pilne-off" class="yesornot btn" id="no">Nie</label>
                </div>
            </div>
            <div class="input-group flex-column">
                <label class="mb-0 mt-2">Wyświetl jako ALARM</label>
                <div class="btn-group btn-group-yesno-pilne radio col-9 pl-0">
                    <input id="alarm-on" name="alarm" class="yesornot " value='1' type="radio">
                    <label for="alarm-on" class="yesornot btn" id="yes">Tak</label>
                    <input id="alarm-off" name="alarm" class="yesornot" value='0' checked type="radio">
                    <label for="alarm-off" class="yesornot btn" id="no">Nie</label>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="author_id" value="{{ Auth::user()->id }}">
    <input type="hidden" name="modified_by" value="0">
</form>


<script type="text/javascript">
    if($('.has_position').is(":checked"))
        $(".pozycjakafelka").show();
    else
        $(".pozycjakafelka").hide();
    function valueChanged()
    {
        if($('.has_position').is(":checked"))
            $(".pozycjakafelka").show();
        else
            $(".pozycjakafelka").hide();
    }
</script>
<script>
    $('#bologna-list a').on('click', function (e) {
        e.preventDefault()
        $(this).tab('show')
    })
    // $('input[type=file]').on('change', function(e) {
    //     var fileName = e.target.files[0].name;
    //     $(this).next('.custom-file-label').html(fileName);
    // });

    $('input[name=image_not_required]').on('change', function (e) {
        image_not_required_no = $('input[name=image_not_required][value=0]').prop("checked");
        image_not_required_yes = $('input[name=image_not_required][value=1]').prop("checked");
        if (image_not_required_no) {
            $('#image_upload_box').show();
        }
        if (image_not_required_yes) {
            $('#image_upload_box').hide();
        }
    });
</script>

<script>
var route_prefix = "/filemanager";
</script>

<!-- CKEditor init -->
<script src="{{asset('ckeditor/ckeditor.js')}}"></script>
<script src="{{asset('ckeditor/adapters/jquery.js')}}"></script>
<script>
var ckeditor = CKEDITOR.replace('ce', {
    height: 450,
    filebrowserImageBrowseUrl: route_prefix + '?type=Images',
//   filebrowserImageUploadUrl: route_prefix + '/upload?type=Images&_token={{csrf_token()}}',
    filebrowserBrowseUrl: route_prefix + '?type=Files',
//   filebrowserUploadUrl: route_prefix + '/upload?type=Files&_token={{csrf_token()}}'
    extraPlugins: 'embed',
    embed_provider: '//ckeditor.iframe.ly/api/oembed?url={url}&callback={callback}',
    removePlugins: 'exportpdf'
});
</script>
<script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
<script>
$('#lfm').filemanager('image', {prefix: route_prefix});
// $('#lfm').filemanager('file', {prefix: route_prefix});
</script>
<script>
var lfm = function(id, type, options) {
    let button = document.getElementById(id);

    button.addEventListener('click', function () {
    var route_prefix = (options && options.prefix) ? options.prefix : '/filemanager';
    var target_input = document.getElementById(button.getAttribute('data-input'));
    var target_preview = document.getElementById(button.getAttribute('data-preview'));

    window.open(route_prefix + '?type=' + options.type || 'file', 'FileManager', 'width=900,height=600');
    window.SetUrl = function (items) {
        var file_path = items.map(function (item) {
        return item.url;
        }).join(',');

        // set the value of the desired input to image url
        target_input.value = file_path;
        target_input.dispatchEvent(new Event('change'));

        // clear previous preview
        target_preview.innerHtml = '';

        // set or change the preview image src
        items.forEach(function (item) {
        let img = document.createElement('img')
        img.setAttribute('style', 'height: 5rem')
        img.setAttribute('src', item.thumb_url)
        target_preview.appendChild(img);
        });

        // trigger change event
        target_preview.dispatchEvent(new Event('change'));
    };
    });
};

lfm('lfm2', 'file', {prefix: route_prefix});
</script>
@endsection
