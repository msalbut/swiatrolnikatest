@extends('layouts.admin')
@section('content')
            <div class="card text-black">
                <div class="card-header bg-success d-flex justify-content-between"><span class="text-white">{{ $title }}</span><a href="{{ route('administrator.polls.create') }}" class="text-white">Dodaj nowy</a> </div>
                <div class="card-body">
                  <table class="table">
                    <thead class="thead-light">
                      <tr>
                        <th scope="col" class="text-center">Stan</th>
                        <th scope="col">Tytuł</th>
                        <th scope="col">Utworzył</th>
                        <th scope="col">Ostatni edytował</th>
                        <th scope="col">Data utworzenia</th>
                        <th scope="col">Data edycji</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($polls as $key => $poll)
                        <tr>
                            <td class="text-center">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    @if($poll->published == 1)
                                        <a  href="{{route('administrator.polls.change', ['id'=>$poll->id])}}?action=unpublish" class="btn btn-light p-1" data-toggle="tooltip" data-placement="top" title="Artykuł opublikowany"><i class="fas fa-check" style="color: #00a143;"></i></a>
                                    @elseif($poll->published == 0)
                                        <a href="{{route('administrator.polls.change', ['id'=>$poll->id])}}?action=publish" class="btn btn-light p-1" data-toggle="tooltip" data-placement="top" title="Artykuł wycofany z publikacji"><i class="fas fa-times" style="color: red;"></i></a>
                                    @endif
                                        <button data-toggle="dropdown" class="p-1 btn-light dropdown-toggle btn btn-micro"></button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="{{route('administrator.polls.change', ['id'=>$poll->id])}}?action=archive" class="text-dark">
                                                <i class="fas fa-archive ml-3"></i>
                                                Archiwizuj</a>
                                            </li>
                                            <hr>
                                            <li>
                                                <a href="{{route('administrator.polls.change', ['id'=>$poll->id])}}?action=delete" class="text-dark"><i class="far fa-trash-alt ml-3"></i> Wyrzuć</a>
                                            </li>
                                        </ul>
                                </div>
                            </td>
                            <th scope="row" style="font-size: 10px;" class="align-middle">
                            @if($poll->published == 1)
                                <a style="color:#015524" href="{{route('administrator.polls.edit', ['id' => $poll->id])}}">{{$poll->title}}</a>
                            @else
                                <a style="color:#9e1511" href="{{route('administrator.polls.edit', ['id' => $poll->id])}}">{{$poll->title}}</a>
                            @endif
                            </th>
                            <th scope="row" style="font-size: 10px;" class="align-middle">
                                {{$poll->creator->name ?? ''}}
                            </th>
                            <th scope="row" style="font-size: 10px;" class="align-middle">
                                {{$poll->lastEditor->name ?? ''}}
                            </th>
                            <th scope="row" style="font-size: 10px;" class="align-middle">
                                {{$poll->created_at}}
                            </th>
                            <th scope="row" style="font-size: 10px;" class="align-middle">
                                {{$poll->updated_at}}
                            </th>
                        </tr>
                        @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
          </div>
        </table>
    </div>
<script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        })
    </script>
@endsection
