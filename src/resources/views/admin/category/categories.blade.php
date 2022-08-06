@extends('layouts.admin')
@section('content')
<div class="card text-black">
    <div class="card-header bg-success d-flex justify-content-between"><span class="text-white">{{ $title }}</span><a href="{{ route('administrator.category.create') }}" class="text-white">Dodaj nową</a> </div>
    <div class="card-body">
        <table class="table">
        <thead class="thead-light">
            <tr>
            <th scope="col" width="10%" class="text-start">Stan</th>
            <th scope="col" width="50%">Tytuł</th>
            <th scope="col" width="1%" class="text-center"><i class="fas fa-check text-success"></i></th>
            <th scope="col" width="1%" class="text-center"><i class="fas fa-times-circle text-danger"></i></th>
            <th scope="col" width="1%" class="text-center"><i class="fas fa-inbox"></i></th>
            <th scope="col" width="1%" class="text-center"><i class="fas fa-trash-alt"></i></th>
            <th scope="col" width="1%" class="text-center">ID</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($main_category as  $key => $category)
            <tr>
                <td class="text-start">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        @if ($category->published == 1)
                            <a href="{{route('administrator.category.change', ['id'=>$category->id])}}?action=unpublish" class="btn btn-light p-1" data-toggle="tooltip" data-placement="top" title="Wycofaj z publikacji"><i class="fas fa-check" style="color: #00a143;"></i></a>
                        @else
                            <a href="{{route('administrator.category.change', ['id'=>$category->id])}}?action=publish" class="btn btn-light p-1" data-toggle="tooltip" data-placement="top" title="Nie opublikowano. Kliknij, aby opublikować. "><i class="fas fa-times" style="color: red;"></i></a>
                        @endif
                        <button data-toggle="dropdown" class="p-1 btn-light dropdown-toggle btn btn-micro"></button>
                        <ul class="dropdown-menu">
                            <li><a href="{{route('administrator.category.change', ['id'=>$category->id])}}?action=archive" class="text-dark">
                            <i class="fas fa-archive ml-3"></i> Archiwizuj</a></li>
                            <hr>
                            <li><a href="{{route('administrator.category.change', ['id'=>$category->id])}}?action=delete" class="text-dark"><i class="far fa-trash-alt ml-3"></i> Wyrzuć</a></li>
                        </ul>
                    </div>
                </td>
                <th scope="row" width="50%" class="text-start align-middle" style="font-size: 14px;"><span class="muted"></span>
                    –&nbsp;<a href="{{ route('administrator.category.edit', ['id' => $category->id]) }}">{{$category->title}}</a><span class="small"> (<span>Alias</span>: {{$category->alias}})</th>
                <th scope="row" class="text-center align-middle" style="font-size: 14px;">
                    @if ($ilosc_art[$category->id]['published'] > 0)
                        <a href="{{route('administrator.article.index', ['catid' => $category->id])}}&state=publish" style="min-width: 50px;" class="badge badge-success d-flex align-items-center justify-content-center">{{$ilosc_art[$category->id]['published']}}</a>
                    @else
                        <a href="{{route('administrator.article.index', ['catid' => $category->id])}}&state=publish" style="min-width: 50px;" class="badge badge-secondary d-flex align-items-center justify-content-center">{{$ilosc_art[$category->id]['published']}}</a>
                    @endif
                </th>
                <th scope="row" class="text-center align-middle" style="font-size: 14px;">
                    @if ($ilosc_art[$category->id]['unpublished'] > 0)
                        <a href="{{route('administrator.article.index', ['catid' => $category->id])}}&state=unpublish" style="min-width: 50px;" class="badge badge-danger d-flex align-items-center justify-content-center">{{$ilosc_art[$category->id]['unpublished']}}</a>
                    @else
                        <a href="{{route('administrator.article.index', ['catid' => $category->id])}}&state=unpublish" style="min-width: 50px;" class="badge badge-secondary d-flex align-items-center justify-content-center">{{$ilosc_art[$category->id]['unpublished']}}</a>
                    @endif
                </th>
                <th scope="row" class="text-center align-middle" style="font-size: 14px;">
                    @if ($ilosc_art[$category->id]['archive'] > 0)
                        <a href="{{route('administrator.article.index', ['catid' => $category->id])}}&state=archive" style="min-width: 50px;" class="badge badge-info d-flex align-items-center justify-content-center">{{$ilosc_art[$category->id]['archive']}}</a>
                    @else
                        <a href="{{route('administrator.article.index', ['catid' => $category->id])}}&state=archive" style="min-width: 50px;" class="badge badge-secondary d-flex align-items-center justify-content-center">{{$ilosc_art[$category->id]['archive']}}</a>
                    @endif
                </th>
                <th scope="row" class="text-center align-middle" style="font-size: 14px;">
                    @if ($ilosc_art[$category->id]['trash'] > 0)
                        <a href="{{route('administrator.article.index', ['catid' => $category->id])}}&state=trash" style="min-width: 50px;" class="badge badge-dark d-flex align-items-center justify-content-center">{{$ilosc_art[$category->id]['trash']}}</a>
                    @else
                        <a href="{{route('administrator.article.index', ['catid' => $category->id])}}&state=trash" style="min-width: 50px;" class="badge badge-secondary d-flex align-items-center justify-content-center">{{$ilosc_art[$category->id]['trash']}}</a>
                    @endif
                </th>
                <th scope="row" class="text-center align-middle" style="font-size: 14px;">{{$category->id}}</th>
            </tr>
            @if(isset($secoundary_category[$category->id]))
            @foreach ($secoundary_category[$category->id] as $key => $category_lv2)
            <tr>
                    <td class="text-start">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        @if ($category_lv2->published == 1)
                            <a href="{{route('administrator.category.change', ['id'=>$category_lv2->id])}}?action=unpublish" class="btn btn-light p-1" data-toggle="tooltip" data-placement="top" title="Wycofaj z publikacji"><i class="fas fa-check" style="color: #00a143;"></i></a>
                        @else
                            <a href="{{route('administrator.category.change', ['id'=>$category_lv2->id])}}?action=publish" class="btn btn-light p-1" data-toggle="tooltip" data-placement="top" title="Nie opublikowano. Kliknij, aby opublikować. "><i class="fas fa-times" style="color: red;"></i></a>
                        @endif
                        <button data-toggle="dropdown" class="p-1 btn-light dropdown-toggle btn btn-micro"></button>
                        <ul class="dropdown-menu">
                            <li><a href="{{route('administrator.category.change', ['id'=>$category_lv2->id])}}?action=archive" class="text-dark">
                            <i class="fas fa-archive ml-3"></i> Archiwizuj</a></li>
                            <hr>
                            <li><a href="{{route('administrator.category.change', ['id'=>$category_lv2->id])}}?action=delete" class="text-dark"><i class="far fa-trash-alt ml-3"></i> Wyrzuć</a></li>
                        </ul>
                    </div>
                </td>
                <th scope="row" style="font-size: 12px;" class="align-middle">
                    <span class="muted">┊&nbsp;&nbsp;&nbsp;</span>
                    –&nbsp;
                    <a href="{{ route('administrator.category.edit', ['id' => $category_lv2->id]) }}">{{$category_lv2->title}}</a><span class="small"> (<span>Alias</span>: {{$category_lv2->alias}})</th>
                    <th scope="row" class="text-center align-middle" style="font-size: 14px;">
                        @if ($ilosc_art[$category_lv2->id]['published'] > 0)
                            <a href="#" style="min-width: 50px;" class="badge badge-success d-flex align-items-center justify-content-center">{{$ilosc_art[$category_lv2->id]['published']}}</a>
                        @else
                            <a href="#" style="min-width: 50px;" class="badge badge-secondary d-flex align-items-center justify-content-center">{{$ilosc_art[$category_lv2->id]['published']}}</a>
                        @endif
                    </th>
                    <th scope="row" class="text-center align-middle" style="font-size: 14px;">
                        @if ($ilosc_art[$category_lv2->id]['unpublished'] > 0)
                            <a href="#" style="min-width: 50px;" class="badge badge-danger d-flex align-items-center justify-content-center">{{$ilosc_art[$category_lv2->id]['unpublished']}}</a>
                        @else
                            <a href="#" style="min-width: 50px;" class="badge badge-secondary d-flex align-items-center justify-content-center">{{$ilosc_art[$category_lv2->id]['unpublished']}}</a>
                        @endif
                    </th>
                    <th scope="row" class="text-center align-middle" style="font-size: 14px;">
                        @if ($ilosc_art[$category_lv2->id]['archive'] > 0)
                            <a href="#" style="min-width: 50px;" class="badge badge-info d-flex align-items-center justify-content-center">{{$ilosc_art[$category_lv2->id]['archive']}}</a>
                        @else
                            <a href="#" style="min-width: 50px;" class="badge badge-secondary d-flex align-items-center justify-content-center">{{$ilosc_art[$category_lv2->id]['archive']}}</a>
                        @endif
                    </th>
                    <th scope="row" class="text-center align-middle" style="font-size: 14px;">
                        @if ($ilosc_art[$category_lv2->id]['trash'] > 0)
                            <a href="#" style="min-width: 50px;" class="badge badge-dark d-flex align-items-center justify-content-center">{{$ilosc_art[$category_lv2->id]['trash']}}</a>
                        @else
                            <a href="#" style="min-width: 50px;" class="badge badge-secondary d-flex align-items-center justify-content-center">{{$ilosc_art[$category_lv2->id]['trash']}}</a>
                        @endif
                    </th>
                    <th scope="row" class="text-center align-middle" style="font-size: 14px;">{{$category_lv2->id}}</th>
            </tr>
                    @endforeach
            @endif
            @endforeach
            </tbody>
        </table>
    </div>
<div class="card-body">
        <table class="table">
        <thead class="thead-light">
            <tr>
            <th scope="col" width="10%" class="text-start">Stan</th>
            <th scope="col" width="50%">Tytuł</th>
            <th scope="col" width="1%" class="text-center"><i class="fas fa-check text-success"></i></th>
            <th scope="col" width="1%" class="text-center"><i class="fas fa-times-circle text-danger"></i></th>
            <th scope="col" width="1%" class="text-center"><i class="fas fa-inbox"></i></th>
            <th scope="col" width="1%" class="text-center"><i class="fas fa-trash-alt"></i></th>
            <th scope="col" width="1%" class="text-center">ID</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($hiddencats as  $key => $categorys)
            <tr>
                <td class="text-start">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        @if ($categorys->published == 1)
                            <a href="{{route('administrator.category.change', ['id'=>$categorys->id])}}?action=unpublish" class="btn btn-light p-1" data-toggle="tooltip" data-placement="top" title="Wycofaj z publikacji"><i class="fas fa-check" style="color: #00a143;"></i></a>
                        @else
                            <a href="{{route('administrator.category.change', ['id'=>$categorys->id])}}?action=publish" class="btn btn-light p-1" data-toggle="tooltip" data-placement="top" title="Nie opublikowano. Kliknij, aby opublikować. "><i class="fas fa-times" style="color: red;"></i></a>
                        @endif
                        <button data-toggle="dropdown" class="p-1 btn-light dropdown-toggle btn btn-micro"></button>
                        <ul class="dropdown-menu">
                            <li><a href="{{route('administrator.category.change', ['id'=>$categorys->id])}}?action=archive" class="text-dark">
                            <i class="fas fa-archive ml-3"></i> Archiwizuj</a></li>
                            <hr>
                            <li><a href="{{route('administrator.category.change', ['id'=>$categorys->id])}}?action=delete" class="text-dark"><i class="far fa-trash-alt ml-3"></i> Wyrzuć</a></li>
                        </ul>
                    </div>
                </td>
                <th scope="row" width="50%" class="text-start align-middle" style="font-size: 14px;"><span class="muted"></span>
                    –&nbsp;<a href="{{ route('administrator.category.edit', ['id' => $categorys->id]) }}">{{$categorys->title}}</a><span class="small"> (<span>Alias</span>: {{$categorys->alias}})</th>
                <th scope="row" class="text-center align-middle" style="font-size: 14px;">
                    @if ($hidden_art[$categorys->id]['published'] > 0)
                        <a href="{{route('administrator.article.index', ['catid' => $categorys->id])}}&state=publish" style="min-width: 50px;" class="badge badge-success d-flex align-items-center justify-content-center">{{$hidden_art[$categorys->id]['published']}}</a>
                    @else
                        <a href="{{route('administrator.article.index', ['catid' => $categorys->id])}}&state=publish" style="min-width: 50px;" class="badge badge-secondary d-flex align-items-center justify-content-center">{{$hidden_art[$categorys->id]['published']}}</a>
                    @endif
                </th>
                <th scope="row" class="text-center align-middle" style="font-size: 14px;">
                    @if ($hidden_art[$categorys->id]['unpublished'] > 0)
                        <a href="{{route('administrator.article.index', ['catid' => $categorys->id])}}&state=unpublish" style="min-width: 50px;" class="badge badge-danger d-flex align-items-center justify-content-center">{{$hidden_art[$categorys->id]['unpublished']}}</a>
                    @else
                        <a href="{{route('administrator.article.index', ['catid' => $categorys->id])}}&state=unpublish" style="min-width: 50px;" class="badge badge-secondary d-flex align-items-center justify-content-center">{{$hidden_art[$categorys->id]['unpublished']}}</a>
                    @endif
                </th>
                <th scope="row" class="text-center align-middle" style="font-size: 14px;">
                    @if ($hidden_art[$categorys->id]['archive'] > 0)
                        <a href="{{route('administrator.article.index', ['catid' => $categorys->id])}}&state=archive" style="min-width: 50px;" class="badge badge-info d-flex align-items-center justify-content-center">{{$hidden_art[$categorys->id]['archive']}}</a>
                    @else
                        <a href="{{route('administrator.article.index', ['catid' => $categorys->id])}}&state=archive" style="min-width: 50px;" class="badge badge-secondary d-flex align-items-center justify-content-center">{{$hidden_art[$categorys->id]['archive']}}</a>
                    @endif
                </th>
                <th scope="row" class="text-center align-middle" style="font-size: 14px;">
                    @if ($hidden_art[$categorys->id]['trash'] > 0)
                        <a href="{{route('administrator.article.index', ['catid' => $categorys->id])}}&state=trash" style="min-width: 50px;" class="badge badge-dark d-flex align-items-center justify-content-center">{{$hidden_art[$categorys->id]['trash']}}</a>
                    @else
                        <a href="{{route('administrator.article.index', ['catid' => $categorys->id])}}&state=trash" style="min-width: 50px;" class="badge badge-secondary d-flex align-items-center justify-content-center">{{$hidden_art[$categorys->id]['trash']}}</a>
                    @endif
                </th>
                <th scope="row" class="text-center align-middle" style="font-size: 14px;">{{$categorys->id}}</th>
            </tr>
            @endforeach
        </tbody>
        </table>
    </div>
    </div>
<script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        })
    </script>
@endsection
