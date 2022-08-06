@extends('layouts.admin', ['title' => 'Menu'])
@section('content')

<div class="card text-black">

    <div class="card-header bg-success d-flex justify-content-between">
        <span class="text-white">Dodawanie pozycji menu: {{$menu->name}} </span>
    </div>
    <div class="card m-4 d-flex flex-row flex-wrap justify-content-between">
    <form class="col-12 m-4" method="post" action="{{ route('administrator.menu.create.position', ['name' => $menu->name])}}">
        @csrf
        <div class="form-group">
            <label for="exampleFormControlSelect1">Example select</label>
                <select class="form-control" id="exampleFormControlSelect1">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                </select>
        </div>
        <button type="submit" class="btn btn-primary col-2">Utwórz</button>
    </form>
    </div>
</div>
@endsection
