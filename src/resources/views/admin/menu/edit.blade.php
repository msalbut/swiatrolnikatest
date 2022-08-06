@extends('layouts.admin', ['title' => 'Edycja menu'])

@section('content')
<form action="{{route('administrator.menu_link.update', $menuLink->id) }}" method="POST">
    @csrf
    <div class="card text-black">
        <div class="card-header bg-success d-flex justify-content-between align-items-center">
            <span class="text-white">Edycja menu</span>
            <button type="submit" class="btn btn-success text-white">Zapisz</button>
        </div>
        <div class="card-body">
            <div class="col-3">
                <div class="control-group">
                    <label for="patent_id" class="m-0">Nadrzędna</label>
                    <select class="custom-select custom-select-sm flex-column" name="parent_id" id="patent_id">
                        {{-- @foreach ($categories as $parent_category) --}}
                            {{-- @if($parent_category->id == $category->parent_id)
                                <option selected value="{{ $parent_category->id }}">- {{ $parent_category->title }} -</option>
                            @else
                                <option value="{{ $parent_category->id }}">┊  - {{ $parent_category->title }} -</option>
                            @endif --}}
                        {{-- @endforeach --}}
                    </select>
                </div>
            </div>
        </div>
</form>

<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    })
</script>
@endsection
