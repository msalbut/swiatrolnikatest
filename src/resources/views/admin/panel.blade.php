@extends('layouts.admin')
@section('content')
<div class="card text-black" >
<div class="card-header bg-success text-white">Informacje</div>
<div class="card-body">
    <div class="card-group">
    <div class="card mr-2">
        <div class="card-body card-body bg-light">
        <div class="card-title">
                <h2 class="d-flex align-items-center justify-content-center text-dark"><i
                class="far fa-newspaper mr-1">&nbsp;</i> <span >{{$count['article']}}</span></h2>
                <h4 class="d-flex justify-content-center">Artykuły</h4>
        </div>
        </div>
    </div>
    <div class="card mr-2">
        <div class="card-body card-body bg-light">
        <div class="card-title">
                <h2 class="d-flex align-items-center justify-content-center text-dark"><i
                class="far fa-folder-open mr-1">&nbsp;</i> <span >{{$count['category']}}</span></h2>
                <h4 class="d-flex justify-content-center">Kategorie</h4>
        </div>
        </div>
    </div>
    <div class="card mr-2">
        <div class="card-body card-body bg-light">
        <div class="card-title">
                <h2 class="d-flex align-items-center justify-content-center text-dark"><i
                class="far fa-user mr-1">&nbsp;</i> <span >{{$count['user']}}</span></h2>
                <h4 class="d-flex justify-content-center">Użytkownicy</h4>
        </div>
        </div>
    </div>
    </div>
</div>
</div>

<!-- Latest Users -->
<div class="card text-black">
<div class="card-header bg-success text-white">Latest Users</div>
<div class="card-body">
    <table class="table">
    <thead class="thead-light">
        <tr>
        <th scope="col">#</th>
        <th scope="col">Pełna nazwa</th>
        <th scope="col">Ostatnie logowanie</th>
        <th scope="col">Grupa</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $key => $user)
            <tr>
                <th scope="row">{{ $user->id }}</th>
                <td>{{ $user->name }}</td>
                <td>{{ $user->lastvisitDate }}</td>
                @if(!is_null($user->user_group_id))
                    <td>{{ $user->usergroup->title }}</td>
                @else
                    <td></td>
                @endif
            </tr>
        @endforeach
    </tbody>
    </table>
</div>
</div>
@endsection
