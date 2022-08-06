@extends('layouts.admin', ['title' => 'Menu'])

@section('content')
<div class="card text-black">
    @foreach ($structures as $key => $menu)
    <div class="card-header bg-success d-flex justify-content-between">
        <span class="text-white">Menu: {{ $key }}</span>
        <a href="{{ route('administrator.menu.create.position', ['name' => $key]) }}" class="text-white">Dodaj nową pozycje</a>
    </div>

    <div class="card-body">
        <table class="table">
            <thead class="thead-light">
                <tr>
                    <th width="10%" class="text-start">Stan</th>
                    <th width="50%">Tytuł</th>
                    <th width="1%" class="text-center">Edytuj</th>
                    <th width="1%" class="text-center">Usuń</th>
                    <th width="1%" class="text-center">ID</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($menu as $menu)
                <tr>
                    <td></td>
                    <td class="text-start align-middle" style="font-size: 14px; font-weight: bold;">
                        –&nbsp;<a href="{{ route('administrator.category.edit', $menu->category->id) }}">{{ $menu->category->title }}</a>
                    </td>
                    <td class="text-center align-middle">
                        <a href="{{route('administrator.menu_link.edit', $menu->id) }}" style="color: black;">
                            <i class="fa-solid fa-pen"></i>
                        </a>
                    </td>
                    <td class="text-center align-middle">
                        <a href="{{route('administrator.menu_link.destroy', $menu->id) }}" style="color: black;">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </td>
                    <td class="text-center align-middle">{{ $menu->id }}</td>
                </tr>
                @foreach ($menu->children as $childmenu)
                <tr>
                    <td></td>
                    <td class="text-start align-middle" style="font-size: 14px; font-weight: bold;">
                        ┊&nbsp;&nbsp;&nbsp;–&nbsp;<a href="{{ route('administrator.category.edit', $childmenu->category->id ) }}">{{ $childmenu->category->title }}</a>
                    </td>
                    <td class="text-center align-middle">
                        <a href="{{route('administrator.menu_link.edit', $childmenu->id ) }}" style="color: black;">
                            <i class="fa-solid fa-pen"></i>
                        </a>
                    </td>
                    <td class="text-center align-middle">
                        <a href="{{route('administrator.menu_link.destroy', $childmenu->id ) }}" style="color: black;">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </td>
                    <td class="text-center align-middle">{{ $childmenu->id }}</td>
                </tr>
                @endforeach
            @endforeach
            </tbody>
        </table>
    </div>
    @endforeach
</div>

<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    })
</script>
@endsection
