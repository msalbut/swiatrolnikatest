@if($mode == "amp")
    @include('ampstyle.amp-boilerplate')
    @include('ampstyle.amp-custom')
@elseif($type == "default" OR $type == "article" OR $type == "category" AND $mode == 'normal')
    <link defer href="{{ asset('/css/portal.min.css?v=17') }}" rel="stylesheet" type="text/css">
    {{-- <link defer href="{{ asset('/css/portal.css?v=2') }}" rel="stylesheet" type="text/css"> --}}
@endif
