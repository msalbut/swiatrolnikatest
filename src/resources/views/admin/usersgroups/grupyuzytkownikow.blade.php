@extends('layouts.admin')
@section('content')
<div class="card text-black">
    <div class="card-header bg-success d-flex justify-content-between"><span class="text-white">{{ $title }}</span><a href="{{ route('administrator.users.create') }}" class="text-white">Dodaj nowego</a> </div>
    <div class="card-body">
        <table class="table col-6">
            <tbody>
                {{-- @dump($groups) --}}
                
            <thead class="thead-light">
                <tr>
                    <th scope="col" width="50%" class="text-start">Nazwa Grupy</th>
                    <th scope="col" width="50%" class="text-center">Ilość użytkowników w grupie</th>
                </tr>
            </thead>
                @foreach ($groups as $key => $group)
                <tr>
                    <td class="align-middle"><a href="{{ route('administrator.user.groups.edit', ['id' => $group->id]) }}">{{ $group->title }}</a></td>
                    <td class="align-middle text-center">{{ $group->user_count }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
