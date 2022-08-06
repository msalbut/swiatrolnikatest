@extends('layouts.admin')
@section('content')
<div class="card text-black">
    <div class="card-header bg-success d-flex justify-content-between"><span class="text-white">{{ $title }}</span><a href="{{ route('administrator.users.create') }}" class="text-white">Dodaj nowego</a> </div>
    <div class="card-body">
        <table class="table">
            <thead class="thead-light">
                <tr>
                    <th scope="col" width="50%" class="text-start">Pełna nazwa</th>
                    <th scope="col" width="10%" class="text-center">Użytkownik</th>
                    <th scope="col" width="1%" class="text-center">Włączone</th>
                    <th scope="col" width="1%" class="text-center">Aktywne</th>
                    <th scope="col" width="10%" class="text-center">Grupy</th>
                    <th scope="col" width="10%" class="text-center">Ostatnia wizyta</th>
                    <th scope="col" width="10%" class="text-center">Data rejestracji</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $key => $user)
                <tr>
                    <td class="align-middle">{{ $user->name }}</td>
                    <td class="text-center align-middle">{{ $user->username }}</td>
                    <td width="1%" class="text-center align-middle">
                    @if ($user->block == 0)
                        <a href="{{route('administrator.users.change', ['id'=>$user->id])}}?action=ban" class="btn btn-light p-1" style="width: 30px" data-toggle="tooltip" data-placement="top" title="Użytkownik odblokowany"><i class="fas fa-check" style="color: #00a143;"></i></a>
                    @else
                        <a href="{{route('administrator.users.change', ['id'=>$user->id])}}?action=unban" class="btn btn-light p-1" style="width: 30px" data-toggle="tooltip" data-placement="top" title="Użytkownik zablokowany"><i class="fas fa-times" style="color: red;"></i></a>
                    @endif
                    </td>
                    {{-- <td>{{ $user-> }}</td> --}}
                    <td>
                    @if ($user->activ == 0)
                        <a href="{{route('administrator.users.change', ['id'=>$user->id])}}?action=active" class="btn btn-light p-1" style="width: 30px" data-toggle="tooltip" data-placement="top" title="Użytkownik zablokowany"><i class="fas fa-times" style="color: red;"></i></a>
                    @else
                        <a href="{{route('administrator.users.change', ['id'=>$user->id])}}?action=unactive" class="btn btn-light p-1" style="width: 30px" data-toggle="tooltip" data-placement="top" title="Użytkownik odblokowany"><i class="fas fa-check" style="color: #00a143;"></i></a>
                    @endif
                    </td>
                    <td></td>
                    <td class="text-center align-middle">{{ $user->lastvisitDate }}</td>
                    <td class="text-center align-middle">{{ $user->created_at }}</td>
                </tr>

                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
