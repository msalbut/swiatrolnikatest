@foreach($propozycje as $key => $propozycja)
    <h3><a href="{{ Config::get('app.url') }}/{{$propozycja->category->path}}/{{$propozycja->alias}}">{{$propozycja->title}}</a></h3>
    <div class="author">Autor: {{$propozycja->user->name ?? ''}} {{ $propozycja->publish_up }}</div>
    <div class="fotka">
        <a href="{{ Config::get('app.url') }}/{{$propozycja->category->path}}/{{$propozycja->alias}}">
            {!!App\Classes\Images::mainImage($propozycja, false)!!}
        </a>
    </div>
    <div class="tresc">
        <a class="polecane_link" href="{{ Config::get('app.url') }}/{{$propozycja->category->path}}/{{$propozycja->alias}}">
            {!! App\Classes\Helper::propozycjaText($propozycja) !!}
        </a>
        <div class="readmore">
            <div class="btnReadmore"><a href="{{ Config::get('app.url') }}/{{$propozycja->category->path}}/{{$propozycja->alias}}">Czytaj dalej</a></div>
        </div>
    </div>
    <hr>

@endforeach
