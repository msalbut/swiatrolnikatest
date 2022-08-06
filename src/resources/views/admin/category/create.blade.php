@extends('layouts.admin')
@section('content')
<form action="{{route('administrator.category.create')}}" method="post">
@csrf
<div class="card text-black">
    <div class="card-header d-inline-flex justify-content-between bg-success text-white edit-article-card-header align-items-center">
        <div class="title_headbar">{{ $title }}</div>
        <div class="function_button">
            <button class="btn btn-success" type="submit" name="btn" value="zapisz">Zapisz</button>
            <button class="btn btn-success" type="submit" name="btn" value="zapisz-i-zamknij">Zapisz i zamknij</a>
            <button class="btn btn-success" type="submit" name="btn" value="zamknij">Zamknij</a>
        </div>
    </div>
    <div class="d-flex align-items-center form-group edit-title mt-3 mx-1">
        <div class="col-6 d-flex pl-0 align-items-center">
            <label class="p-2 mb-0">Tytuł:</label>
            <input class="form-control" type="text" name="title" value="{{ old('title') }}"/>
        </div>
    </div>
    <div class="d-inline-flex edit-content">
    <div class="card-body p-0 col-9">
        <div class="card">
        <div class="card-header">
          <ul class="nav nav-tabs card-header-tabs" id="bologna-list" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" href="#tresc" role="tab" aria-controls="description" aria-selected="true">Meta Opis</a>
            </li>
          </ul>
        </div>
        <div class="card-body">
           <div class="tab-content mt-3">
            <div class="tab-pane active" id="tresc" role="tabpanel">
                <textarea class="form-control" name="description" rows="3" style="height:350px;">{{ old('description') }}</textarea>
            </div>
          </div>
        </div>
      </div>
      </div>
        <div class="col-3">
            <div class="control-group">
                <label for="patent_id" class="m-0">Nadrzędna</label>
                <select class="custom-select custom-select-sm flex-column" name="parent_id" id="patent_id">
                    @foreach ($categories as $parent_category)
                        <option value="{{ $parent_category->id }}">┊  - {{ $parent_category->title }} -</option>
                    @endforeach
                </select>
            </div>
            <div class="control-group">
                <label for="stan" class="mt-4 mb-0">Stan</label>
                <select class="custom-select custom-select-sm flex-column" name="published" id="stan">
                    <option selected value="1">Opublikowano</option>
                    <option value="0">Nie opublikowano</option>
                    <option value="2">Zarchowizowano</option>
                    <option value="-2">W koszu</option>
                </select>
            </div>
        </div>
    </div>
</form>
<script>
    $('#bologna-list a').on('click', function (e) {
        e.preventDefault()
        $(this).tab('show')
    })
</script>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    })
</script>
@endsection
