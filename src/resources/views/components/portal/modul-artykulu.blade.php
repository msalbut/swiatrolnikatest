<a href="{{ $category->path }}" style="text-decoration: none;">
    <div class="tytul_kategori_strona_glowna">
        <h2>{{ $nazwa }}</h2>
    </div>
</a>
<div class="kafelek_glowny_kategorii">
    @foreach ($artykuly as $key => $art)
        @if (in_array($art->id, $GLOBALS['id_art']))
            @continue
        @else
            @if ($key == 0)
                <div class="kafelek_glowny_wrapper">
                    <div class="tresc_and_autor">
                        <h3 class="tytul_artykulu">
                            <a href="{{ Config::get('app.url') }}/{{ $art->category->path . '/' . $art->alias }}.html">
                                {{ $art->title }}
                            </a>
                        </h3>
                    </div>
                    <div class="profil_autora_artykulu">
                        <div class="autor_text">
                            <span class="autor">autor</span>
                            <span class="nazwa_autora">{{ $art->user->name }}</span>
                        </div>
                        {{-- @dd($art->User); --}}
                        {{-- <div class="zdjecie_autora">
                            <img loading="lazy" src="{{ asset('storage/' . $art->User->userinfo->photo) }}"
                                alt="{{ $art->User->name }}">
                        </div> --}}
                    </div>
                </div>

                <div class="zdjecie">
                    <div class="n0">
                        @if ($art->hasLabel())
                            <span class="etykieta"
                                data-etykieta="{{ $art->etykieta }}">{{ $art->getLabel() }}</span>
                        @endif
                        <a href="{{ Config::get('app.url') }}/{{ $art->category->path.'/'.$art->alias }}.html">
                        {{-- {!!App\Classes\Helper::zdjecianowe($art)!!} --}}
                        {!!App\Classes\Images::mainImage($art, true)!!}

                        </a>
                    </div>
                </div>
            @endif
        @endif
    @endforeach
</div>
<div class="linia-kafelkow">
    @foreach ($artykuly as $key => $art)
        @if ($key > 0 && $key < 13)
            <div class="kafelek">
                <div class="zdjecie">
                    @if ($art->hasLabel())
                        <span class="etykieta" data-etykieta="{{ $art->etykieta }}">{{ $art->getLabel() }}</span>
                    @endif
                    <a href="{{ Config::get('app.url') }}/{{ $art->category->path.'/'.$art->alias }}.html">
                        {!!App\Classes\Images::thumbnail($art, true)!!}
                    </a>
                </div>
                <div class="tytul">
                    <h3><a
                            href="{{ Config::get('app.url') }}/{{ $art->category->path . '/' . $art->alias }}.html">{{ $art->title }}</a>
                    </h3>
                </div>

            </div>
        @endif
    @endforeach
    <div class="zobaczwiecej"><a href="{{ Config::get('app.url') }}/{{ $category->path }}">Więcej</a></div>
</div>
