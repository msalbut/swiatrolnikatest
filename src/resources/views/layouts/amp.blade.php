@php
    $type = $type ?? 'default';
    $mode = $mode ?? 'normal';
@endphp
<!DOCTYPE html>
<html ⚡ lang="pl">

<head>
    @include('layouts.head.head')
</head>

<body>
    @if($mode == 'amp')
        <amp-analytics type="gtag" data-credentials="include">
        <script type="application/json">
        {
        "vars" : {
            "gtag_id": "UA-49266642-2",
            "config" : {
            "UA-49266642-2": { "groups": "default" }
            }
        }
        }
        </script>
    @endif

    </amp-analytics>
    <div class="wrapper">
        {{-- @dd($modules); --}}
        {{-- @dd($type) --}}
        {{-- moduł pilne --}}

        {{-- moduł z logiemsocialami i hasłem --}}
        {{-- <x-portal.pilne /> --}}
        {{-- {{$modules->view}} --}}
        <x-portal.header :type="$type" :mode="$mode" />

        {{-- moduł z menu --}}
        <x-amp.menu />

        {{-- <x-portal.menu /> --}}
        <div class="kontener-glowny-amp">
            @yield('content')
        </div>
        <footer id="sekcja11">
            {{-- <x-portal.hodowla /> --}}
            <x-portal.footer :type="$type" :mode="$mode" />
        </footer>
    </div>
</body>

</html>
