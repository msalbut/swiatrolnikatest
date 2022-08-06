@extends('layouts.admin')
@section('content')
<form action="{{route('administrator.users.create')}}" method="post">
@csrf
<div class="card text-black">
    <div class="card-header d-inline-flex justify-content-between bg-success text-white edit-article-card-header align-items-center">
        <div class="title_headbar">{{ $title }}</div>
        <div class="function_button">
            <button class="btn btn-success" type="submit" name="btn" value="zapisz">Zapisz</button>
            <button class="btn btn-success" type="submit" name="btn" value="zapisz-i-zamknij">Zapisz i zamknij</a>
            <button class="btn btn-success" type="submit" name="btn" value="zapisz-i-nowy">Zapisz i nowy</a>
            <button class="btn btn-success" type="submit" name="btn" value="zamknij">Zamknij</a>
        </div>
    </div>
    <div class="form-group row mx-0 my-2 col-6">
        <label for="inputPassword" class="col-sm-2 col-form-label p-0 d-flex align-items-center">Nazwa</label>
        <div class="col-sm-10">
            <input type="password" class="form-control" id="inputPassword" placeholder="Nazwa">
        </div>
    </div>
    <div class="form-group row mx-0 my-2 col-6">
        <label for="inputPassword" class="col-sm-2 col-form-label p-0 d-flex align-items-center">Nazwa użytkownika</label>
        <div class="col-sm-10">
            <input type="password" class="form-control" id="inputPassword" placeholder="Nazwa użytkownika">
        </div>
    </div>
    <div class="form-group row mx-0 my-2 col-6">
        <label for="inputPassword" class="col-sm-2 col-form-label p-0 d-flex align-items-center">Hasło</label>
        <div class="col-sm-10">
            <input type="password" class="form-control" id="inputPassword" placeholder="Hasło">
        </div>
    </div>
    <div class="form-group row mx-0 my-2 col-6">
        <label for="inputPassword" class="col-sm-2 col-form-label p-0 d-flex align-items-center">Powtórz hasło</label>
        <div class="col-sm-10">
            <input type="password" class="form-control" id="inputPassword" placeholder="Powtórz hasło">
        </div>
    </div>
    <div class="form-group row mx-0 my-2 col-6">
        <label for="inputPassword" class="col-sm-2 col-form-label p-0 d-flex align-items-center">E-mail</label>
        <div class="col-sm-10">
            <input type="password" class="form-control" id="inputPassword" placeholder="E-mail">
        </div>
    </div>
    <div class="form-group row mx-0 my-2 col-6">
        <label class="mb-0 mt-2">Wyróżnione</label>
        <div class="btn-group btn-group-yesno radio col-9 pl-0">
            <input id="toggle-on" name="toggle" class="yesornot " value='1' checked type="radio">
            <label for="toggle-on" class="yesornot btn" id="yes">Tak</label>
            <input id="toggle-off" name="toggle" class="yesornot" value='0' type="radio">
            <label for="toggle-off" class="yesornot btn" id="no">Nie</label>
        </div>
    </div>
@endsection
