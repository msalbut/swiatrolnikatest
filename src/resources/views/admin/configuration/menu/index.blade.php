@extends('layouts.admin', ['title' => 'Menu'])
@section('content')

<div class="card text-black">

    <div class="card-header bg-success d-flex justify-content-between">
        <span class="text-white">Menu: </span>
    </div>
<div class="card w-50 m-4">
  <div class="card-body">
    <form action="{{route('administrator.config.menu.change', ['id' => $config->id])}}" method="post" enctype="multipart/form-data">
    @csrf
    <h5 class="card-title">Aktywne menu: {{$config->name}}</h5>
    <select class="custom-select" name='name'>
        @foreach($menutype as $key => $menu)
            <option {{($config->name == $menu->menutype)?'selected':''}} value="{{$menu->menutype}}">{{$menu->menutype}}</option>
        @endforeach
    </select>
    <button type="submit" class="btn btn-primary ml-0 mt-3">Zmień</button>
    </form>
  </div>
</div>
</div>

<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    })
</script>
@endsection
