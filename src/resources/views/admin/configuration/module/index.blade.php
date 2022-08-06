@extends('layouts.admin', ['title' => 'Menu'])
@section('content')

<div class="card text-black">

    <div class="card-header bg-success d-flex justify-content-between">
        <span class="text-white">Moduły: </span>
    </div>
<div class="card m-4 d-flex flex-row flex-wrap justify-content-between">
    @foreach ($config as $key => $conf)
        <div class="card-body border col-4 my-2">
            <span class="btn bg-info text-white"><i class="fas fa-pen" id="{{'edit'.$key}}" onclick="edit({{$key}})"></i></span>
            <a class="btn btn-danger" href="{{route('administrator.config.module.delete', ['id' => $conf->id])}}"><i class="fas fa-trash"></i></a>
            <form action="{{route('administrator.config.module.edit', ['id' => $conf->id])}}" method="post" enctype="multipart/form-data">
                @csrf
            <div class="form-group">
                <label for="nazwa">Nazwa modułu</label>
                <input type="text" class="form-control" id="{{'nazwa'.$key}}" name="name" disabled value="{{$conf->name}}">
            </div>
            <div class="form-group">
                <label for="category">Kategoria</label>
                {{-- @dd($main_category) --}}
                <select class="form-control" id="{{'category'.$key}}" name="category_id" disabled>
                    @foreach ($main_category as $category)

                        <option {{($category->id == $conf->category_id) ? 'selected' : ''}} value="{{ $category->id }}">- {{ $category->title }}</option>
                        @if(isset($secoundary_category[$category->id]))
                            @foreach ($secoundary_category[$category->id] as $category_lv2)
                                <option value="{{ $category_lv2->id }}">&nbsp;&nbsp;|-- {{ $category_lv2->title }}</option>
                            @endforeach
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="pozycja">Pozycja</label>
                <input type="text" class="form-control" id="{{'pozycja'.$key}}" name="position" disabled value="{{$conf->position}}">
            </div>
            <div class="form-group">
                <label for="pozycja">Ikonka</label>
                <input type="text" class="form-control" id="{{'ikona'.$key}}" name="icon" disabled value="{{$conf->icon}}">
            </div>
            <button type="submit" class="btn btn-primary ml-0 d-none" id="btnedytuj{{$key}}">Edytuj</button>
            </form>
        </div>
    @endforeach
</div>
</div>

<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    })
</script>
<script>
    function edit(i){
        $( "#btnedytuj"+i ).removeClass( "d-none" );
        $( "#ikona"+i ).prop( "disabled", false );
        $( "#nazwa"+i ).prop( "disabled", false );
        $( "#category"+i ).prop( "disabled", false );
        $( "#pozycja"+i ).prop( "disabled", false );
    }
</script>
@endsection
