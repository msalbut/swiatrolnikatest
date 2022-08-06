@extends('layouts.portal', ['type' => 'default'])
@section('content')
    <x-portal.news />
    <x-portal.kafelki-top />

    <section id="sekcja3">
        <x-portal.sonda />
        <x-portal.top10 />
    </section>
    @php
        $i = 4;
    @endphp
    @foreach ($config as $module)
        @if($module->type == 'module')
            <section id="{{'sekcja'.$i}}" class="{{$module->class}}">
                <x-portal.modul-artykulu :id="$module->category_id" :nazwa="$module->name" :icon="$module->icon"/>
            </section>
            @php
                ++$i;
            @endphp

        @elseif($module->type == 'other_module' AND $sprawdz)
            {{-- <section id="{{'sekcja'.$i}}" class="{{$module->class}}">
                <x-portal.alarm :nazwa="$module->name"/>
            </section>
            @php
                ++$i;
            @endphp --}}
        @endif

    @endforeach
@endsection
