@extends('layouts.admin')
@section('content')


        @if($content->fulltext == "")
        @php echo $content->fulltext; @endphp
        @else
           @php echo $content->fulltext; @endphp

        @endif
    @endphp

@endsection
