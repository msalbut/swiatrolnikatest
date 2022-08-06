@php
    $counter = 0;
@endphp
<div class="articles-right">
    @foreach($artykuly as $key => $propozycja)
        @if(isset($_COOKIE[$propozycja->id]) || $counter >= 10)
            @continue
        @else
            <div class="rightBoxCard">

                <a href="{{ Config::get('app.url') }}/{{$propozycja->category->path}}/{{$propozycja->alias}}">
                    {{-- {!!App\Classes\Helper::zdjecianoweart($propozycja)!!} --}}
                    {!!App\Classes\Images::thumbnail($propozycja, false)!!}
                </a>
                <a class="title" href="{{ Config::get('app.url') }}/{{$propozycja->category->path}}/{{$propozycja->alias}}">{{$propozycja->title}}</a><br>
            </div>
            @php
                $counter++;
            @endphp
        @endif
    @endforeach
</div>
