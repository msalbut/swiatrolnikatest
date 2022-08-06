@extends('layouts.admin', ['title' => 'Menu'])
@section('content')

<div class="card text-black">

    <div class="card-header bg-success d-flex justify-content-between">
        <span class="text-white">Tworzenie menu: </span>
    </div>
    <div class="card m-4 d-flex flex-row flex-wrap justify-content-between">
    <form class="col-12 m-4" method="post" action="{{ route('administrator.menu.create')}}">
        @csrf
        <div class="form-group col-4">
            <label for="name">Nazwa menu</label>
            <input type="text" class="form-control" id="name" name="name" aria-describedby="nameHelp" value="{{old('name')}}">
            <small id="nameHelp" class="form-text text-muted">Nazwa nie jest nigdzie widoczna, służy do rozróżnienia menu dla Administratora</small>
        </div>
        <button type="submit" class="btn btn-primary col-2">Utwórz</button>
    </form>
    </div>
</div>
@endsection
