@extends('layouts.admin')
@section('content')
            <form action="" method="GET">
                <div class="form-row mb-3">
                    <div class="control-group">
                        <label class="mb-0">Tytuł</label>
                        <input class="form-control form-control-sm" type="text" name="title" value="{{ request('title') }}" />
                    </div>
                    <div class="control-group">
                        <label class="mb-0">Kategoria</label>
                        <select class="custom-select custom-select-sm" name="catid">
                            <option value="">Wszystkie</option>
                            @foreach($categories as $key => $category)

                                @if(request()->catid == $category->id)
                                <option selected value="{{$category->id}}">{{$category->title}}</option>
                                @else
                                <option value="{{$category->id}}">{{$category->title}}</option>
                                @endif
                            @endforeach
                        </select>

                    </div>
                    <div class="control-group">
                        <label class="mb-0">Stan</label>
                        {{-- @dd(request()->state ) --}}
                            <select class="custom-select custom-select-sm" name="state">
                                <option></option>
                               <option {{(request()->state == 'publish') ? 'selected' : ''}} value="publish">Opublikowane</option>
                               <option {{(request()->state == 'unpublish') ? 'selected' : ''}} value="unpublish">Nie opublikowane</option>
                               <option {{(request()->state == 'archive') ? 'selected' : ''}} value="archive">Zarchiwizowane</option>
                               <option {{(request()->state == 'trash') ? 'selected' : ''}} value="trash">W koszu</option>
                            </select>
                    </div>
                    <div class="control-group">
                        <label class="m-0">Autor</label>
                        <select class="custom-select custom-select-sm" name="author">
                            <option value=''></option>
                            @foreach($users as $key => $user)
                                <option {{(request()->author == $user->id) ? 'selected' : ''}} value='{{ $user->id }}'>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Szukaj</button>
                </div>
            </form>
            <div class="card text-black">
                <div class="card-header bg-success d-flex justify-content-between"><span class="text-white">{{ $title }}</span><a href="{{ route('administrator.article.create') }}" class="text-white">Dodaj nowy</a> </div>
                <div class="card-body">
                  <table class="table">
                    <thead class="thead-light">
                      <tr>
                        <th scope="col" class="text-center">#ID</th>
                        <th scope="col" class="text-center">Stan</th>
                        <th scope="col">Tytuł</th>
                        <th scope="col">Kategoria</th>
                        <th scope="col">Autor</th>
                        @if(Auth::user()->CheckAccessForAccesTo('dodatkowe'))
                            <th scope="col">Utworzył</th>
                            <th scope="col">Ostatni edytował</th>
                        @endif
                        <th scope="col" class="text-center">
                            @if(request()->sort == "publishUp")
                            <a href="{{ route('administrator.article.index', array_merge(request()->all(), ['sort' => 'publishDown'])) }}">Data utworzenia<br>publikacji <i class="fas fa-caret-up"></i></a>
                            @elseif (request()->sort == "publishDown")
                            <a href="{{ route('administrator.article.index', array_merge(request()->all(), ['sort' => 'publishUp'])) }}">Data utworzenia<br>publikacji <i class="fas fa-caret-down"></i></a>
                            @else
                            <a href="{{ route('administrator.article.index', array_merge(request()->all(), ['sort' => 'publishUp'])) }}">Data utworzenia<br>publikacji</a>
                            @endif
                        </th>
                        <th scope="col" class="text-center">
                            @if(request()->sort == "hitsUp")
                            <a href="{{ route('administrator.article.index', array_merge(request()->all(), ['sort' => 'hitsDown'])) }}">Wyświetlenia <i class="fas fa-caret-up"></i></a>
                            @elseif (request()->sort == "hitsDown")
                            <a href="{{ route('administrator.article.index', array_merge(request()->all(), ['sort' => 'hitsUp'])) }}">Wyświetlenia <i class="fas fa-caret-down"></i></a>
                            @else
                            <a href="{{ route('administrator.article.index', array_merge(request()->all(), ['sort' => 'hitsUp'])) }}">Wyświetlenia</a>
                            @endif
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($content as $key=>$art)
                        <tr>
                            <td class="text-center align-middle">#{{$art->id}}</td>
                            <td class="text-center align-middle">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    @if ($art->state == 1 AND $art->publish_up > date("Y-m-d H:i:s"))
                                        <a  href="{{route('administrator.article.change', ['id'=>$art->id])}}?action=unpublish" class="btn btn-light p-1" data-toggle="tooltip" data-placement="top" data-html="true" title="Artykuł zaplanowany (publikacja nastąpi: <br /> {{$art->publish_up}})"><i class="fas fa-exclamation-triangle" style="color: #c67605;"></i></a>
                                    @elseif($art->state == 1)
                                        <a  href="{{route('administrator.article.change', ['id'=>$art->id])}}?action=unpublish" class="btn btn-light p-1" data-toggle="tooltip" data-placement="top" title="Artykuł opublikowany"><i class="fas fa-check" style="color: #00a143;"></i></a>
                                    @elseif($art->state == 0)
                                        <a href="{{route('administrator.article.change', ['id'=>$art->id])}}?action=publish" class="btn btn-light p-1" data-toggle="tooltip" data-placement="top" title="Artykuł wycofany z publikacji"><i class="fas fa-times" style="color: red;"></i></a>
                                    @endif
                                    @if ($art->featured == 1)
                                        <a href="{{route('administrator.article.change', ['id'=>$art->id])}}?action=unfeatured" class="btn btn-light p-1" data-toggle="tooltip" data-placement="top" title="Artykuł wyróżniony"><i class="fas fa-star" style="color: #c67605;"></i></a>
                                    @else
                                        <a href="{{route('administrator.article.change', ['id'=>$art->id])}}?action=featured" class="btn btn-light p-1" data-toggle="tooltip" data-placement="top" title="Artykuł niewyróżniony"><i class="far fa-star"></i></a>
                                    @endif
                                        <button data-toggle="dropdown" class="p-1 btn-light dropdown-toggle btn btn-micro"></button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="{{route('administrator.article.change', ['id'=>$art->id])}}?action=archive" class="text-dark">
                                                <i class="fas fa-archive ml-3"></i>
                                                Archiwizuj</a>
                                            </li>
                                            <hr>
                                            <li>
                                                <a href="{{route('administrator.article.change', ['id'=>$art->id])}}?action=delete" class="text-dark"><i class="far fa-trash-alt ml-3"></i> Wyrzuć</a>
                                            </li>
                                        </ul>
                                        @if(!is_null($art->isBlocked()))
                                            <a href="{{route('administrator.article.unlock', ['id'=>$art->isBlocked()->id])}}"><i style="color:red;" class="fas fa-user-lock" data-toggle="tooltip" data-placement="top" data-html="true" title="Artykuł zablokowany przez <br> {{$art->isBlocked()->user->name}}"></i></a>
                                        @endif
                                </div>
                            </td>
                            <th scope="row" style="font-size: 10px;" class="align-middle">
                            @if($art->state == 1 AND $art->publish_up > date("Y-m-d H:i:s"))
                            <a style="color:#e98e05" href="{{route('administrator.article.edit', ['id' => $art->id])}}">{{$art->title}}</a>
                            {!! $art->hasLabel() ? '<div><b>'.$art->getLabel().'</b></div>' : '' !!}
                            @elseif($art->state == 1)
                            <a style="color:#015524" href="{{route('administrator.article.edit', ['id' => $art->id])}}">{{$art->title}}</a>
                            {!! $art->hasLabel() ? '<div><b>'.$art->getLabel().'</b></div>' : '' !!}
                            @else
                            <a style="color:#9e1511" href="{{route('administrator.article.edit', ['id' => $art->id])}}">{{$art->title}}</a>
                            {!! $art->hasLabel() ? '<div><b>'.$art->getLabel().'</b></div>' : '' !!}
                            @endif
                            </th>
                            <th scope="row" style="font-size: 10px;" class="align-middle">{{$art->category->title}}</th>
                            <th scope="row" style="font-size: 10px;" class="align-middle">{{$art->user->name ?? ''}}</th>
                            @if(Auth::user()->CheckAccessForAccesTo('dodatkowe'))
                                <th scope="row" style="font-size: 10px;" class="align-middle">{{$art->creator->name ?? ''}}</th>
                                <th scope="row" style="font-size: 10px;" class="align-middle">{{$art->lastEditor->name ?? ''}}</th>
                            @endif
                            <td class="text-center align-middle"><span style="color:#c67605; font-size: 12px;">{{$art->created_at}}</span><br>{{$art->publish_up}}</td>
                            <td class="text-center align-middle">{{$art->hits}}</td>

                        </tr>
                        @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
          </div>
        </table>
        <div class="paginate">
            {{ $content->links() }}
        </div>
    </div>
<script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        })
    </script>
@endsection
