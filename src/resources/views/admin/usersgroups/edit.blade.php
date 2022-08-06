@extends('layouts.admin')
@section('content')
<form action="{{route('administrator.user.groups.edit', ['id' => $group->id])}}" method="post">
@csrf
<div class="card text-black">
    <div class="card-header d-inline-flex justify-content-between bg-success text-white edit-article-card-header align-items-items-center">
        <div class="title_headbar">{{ $title }}</div>
        <div class="function_button">
            <button class="btn btn-success" type="submit" name="btn" value="zapisz">Zapisz</button>
            <button class="btn btn-success" type="submit" name="btn" value="zapisz-i-zamknij">Zapisz i zamknij</a>
            <button class="btn btn-success" type="submit" name="btn" value="zapisz-i-nowy">Zapisz i nowa</a>
            <button class="btn btn-success" type="submit" name="btn" value="zamknij">Zamknij</a>
        </div>
    </div>
        {{-- @dump($group->permission) --}}
        {{-- @dump($group_permission) --}}

        <input type="checkbox" id="checkAll" > Check All

        @foreach ($permissions as $key => $permission)
        {{-- @dd($permission) --}}
            <div class="form-check px-5">
                <input class="form-check-input check" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="flexCheckChecked" 
                @if(in_array($permission->id, $group_permission))
                checked                    
                @endif>
                <label class="form-check-label" for="flexCheckChecked">
                    {{$permission->name}}
                </label>
            </div>
        @endforeach
</div>
</form>
<script>
     $('#checkAll').click(function () {    
        $(':checkbox.check').prop('checked', this.checked);    
    });
</script>
@endsection
