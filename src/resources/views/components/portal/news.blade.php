<section id="sekcja1">
{{-- { @dd(); --}}
    @php
    $GLOBALS['id_art'] = array($artykulnews->id);
    @endphp
        <div class="first-news">
            {{-- <a href="{{ Config::get('app.url') }}{{$artykulnews->category->path}}/{{$artykulnews->alias}}.html"> --}}
                <div class="first-news-photos">
                    @if ($artykulnews->hasLabel())
                        <span class="etykieta" data-etykieta="{{ $artykulnews->etykieta }}">{{ $artykulnews->getLabel() }}</span>
                    @endif
                    <a href="{{ Config::get('app.url') }}/{{$artykulnews->category->path}}/{{$artykulnews->alias}}.html">
                        {!!App\Classes\Images::mainImage($artykulnews)!!}
                    </a>

                </div>
            {{-- </a> --}}
            <div class="title-first-news">
                <div class="title">
                    <h3><a href="{{ Config::get('app.url') }}/{{$artykulnews->category->path}}/{{$artykulnews->alias}}.html">{{$artykulnews->title}}</a></h3>
                </div>
            </div>
        </div>
        <div class="list-news">
            @foreach ($artykuly as $key => $art)
                @php
                    $diff = \Carbon\Carbon::parse($art->publish_up);
                    $GLOBALS['id_art'][] = $art->id;
                @endphp
                <div class="najnowszeart">
                    <a href="{{ Config::get('app.url') }}/{{$art->category->path}}/{{$art->alias}}.html" style="width: 75%;">
                        <h3>{{$art->title}}</h3>
                    </a>
                    <a href="{{ Config::get('app.url') }}/{{$art->category->path}}/{{$art->alias}}.html" style="width: 20%;">
                        {!!App\Classes\Images::thumbnail($art)!!}
                    </a>
                </div>

                @endforeach
            </div>
        </section>

