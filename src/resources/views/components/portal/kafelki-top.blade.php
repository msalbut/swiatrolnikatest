<section id="sekcja2">
    <div class="linia-kafelkow">
        @php
        $GLOBALS['id_art_kafelki'] = array();
        @endphp
        @foreach ($arts as $key => $art)
        {{-- @dump($key) --}}
            @php
                $GLOBALS['id_art_kafelki'][] = $art->id;
            @endphp
            <div class="kafelek">
                <div class="zdjecie">
                    @if ($art->hasLabel())
                        <span class="etykieta" data-etykieta="{{ $art->etykieta }}">{{ $art->getLabel() }}</span>
                    @endif
                    <a href="{{ Config::get('app.url') }}/{{$art->category->path}}/{{$art->alias}}.html">
                        @if ($key < 4)
                            {!!App\Classes\Images::thumbnail($art)!!}
                        @else
                            {!!App\Classes\Images::thumbnail($art, true)!!}
                        @endif
                    </a>
                </div>
                <div class="tytul">
                    <h3>
                        <a href="{{ Config::get('app.url') }}/{{$art->category->path}}/{{$art->alias}}.html">
                            {{$art->title}}
                        </a>
                </h3>
                </div>
            </div>
       @endforeach
    </div>
</section>
