@extends('layouts.portal', ['type' => 'article'])
@section('content')
        @php
            $urlki = json_decode($article->urls, true);
            if (is_array($urlki)) {
                if(count($urlki)>0){
                $filmik = json_decode($article->urls, true)["urla"];
                }
                else{
                    $filmik = "";
                }
            }
            else {
                $filmik = "";
            }
        @endphp
        <div class="pathAdress">
            @if($article->category->level > 1)
            <a href="{{ Config::get('app.url') }}/{{$article->category->parent->path}}">{{$article->category->parent->title}}</a> / <a href="{{ Config::get('app.url') }}/{{$article->category->path}}"><b>{{$article->category->title}}</b></a> / <a href="{{ Config::get('app.url') }}/{{$article->category->path}}/{{$article->alias}}.html">{{$article->title}}</a>
            @else
            <a href="{{ Config::get('app.url') }}/{{$article->category->path}}"><b>{{$article->category->title}} /</b></a><a href="{{ Config::get('app.url') }}/{{$article->category->path}}/{{$article->alias}}.html">{{$article->title}}</a>
            @endif
        </div>
        <div class="article">
            <div class="content-art">
                <h1>{{$article->title}}</h1>
                @if($article->category->title != 'Strony')
                <div class="author">Autor: {{$article->user->name ?? ''}}  {{ $article->publish_up }}</div>
                @endif
                @if($filmik != "")
                <div class="fotka">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/{{$filmik}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                @else
                <div class="fotka">
                    {!!App\Classes\Images::mainImage($article)!!}
                </div>
                @endif
                <div class="tresc">
                    @php
                        $fulltext = str_replace('href="https://swiatrolnika.info/', 'href="/', $article->fulltext);
                        $fulltext = str_replace('<script async="" charset="utf-8" src="https://platform.twitter.com/widgets.js"></script>', '', $fulltext);
                        $re = '/(\s)?style="(.*)"/mU';
                        $fulltext = preg_replace($re, "", $fulltext);
                    @endphp
                    <?php echo $fulltext; ?>
                    <?php echo $article->fulltext_old; ?>
                </div>
                <hr>
                <div id="propozycje" data-id="{{$article->id}}" data-catid="{{$article->catid}}">
                    {{-- @include('portal.propozycje') --}}
                </div>
            </div>
            <div class="right-box">
                @if ($article->category->title != 'Strony')
                    <x-portal.right-box :catid="$article->catid" :id="$article->id" />
                @endif
                <div class="banery-wrapper">
                    {{-- <a loading="lazy" href="https://bult.dog"><img src="{{ asset('storage/images/banery/baner-bult-400x800.jpg') }}" width="400" height="800" alt="BULT"></a> --}}
                    <a loading="lazy" href="https://nieprzelewaj.pl"><img src="{{ asset('storage/images/banery/Baner-Nie-przelewaj-pion_400x800_3.jpg') }}" width="400" height="800" alt="Nieprzelewaj"></a>
                </div>
            </div>
        </div>
        @push('script')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
            <script type="text/javascript">
                $(document).ready(function() {
                    var processing = true;
                    $(window).scroll(function(){
                        if (processing){
                            if ($(window).scrollTop() >= $(document).height() - $(window).height() - 500){
                                console.log(10);
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                    }
                                });
                                var url = "{{ route('getProposition', ['catid' => ':catid', 'id' => ':id']) }}";
                                url = url.replace(':catid',  $('#propozycje').data('catid'));
                                url = url.replace(':id',  $('#propozycje').data('id'));
                                $.ajax({
                                    url: url,
                                    method: 'get',
                                    // data: {
                                    //     nip: jQuery('#nip').val(),
                                    // },
                                    success: function(strona) {
                                        if (strona.success) {
                                            processing = false;
                                            $('#propozycje').html(strona.html);
                                        }
                                    },
                                });
                            };
                        };
                    });
                });
            </script>
        @endpush
@endsection
