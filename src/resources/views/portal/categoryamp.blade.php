@extends('layouts.amp', ['type' => 'category', 'mode'=>'amp'])
@section('content')
@php
function limit_text($text, $limit)
{
   $text = strip_tags($text);
   $eksplode = explode(" ", $text);
   $policz = count($eksplode);

   if ($policz > $limit) {
       $text = $eksplode[0];
       for ($i = 1; $i < $limit; $i++) {
           $text .= " " . $eksplode[$i];
       }
       echo $text . '...';
   } else {
       echo $text;
   }
}
@endphp
<div class="artofcategory">
        @foreach($articles as $key => $art)
            @if($key == 0)
                <div class="firstartincategory">
                    <div class="photosFirstArt">
                        {{-- {!!App\Classes\Helper::zdjecianoweamp($art)!!} --}}
                    </div>
                    <div class="textOffFirstArt">
                        <a href="{{ Config::get('app.url') }}/{{$art->category->path.'/'.$art->alias.'.html'}}">
                            <h2>{{$art->title}}</h2>
                            <div class="wstepik"><?php limit_text($art->fulltext, 20); ?></div>
                        </a>
                    </div>
                </div>
            @endif
        @endforeach
        <div class="kafelki">
        @foreach($articles as $key => $art)
            @if ($key > 0)
                <div class="kafelek">
                    <div class="zdjecie">
                        <a href="{{ Config::get('app.url') }}/{{$art->category->path.'/'.$art->alias.'.html'}}">
                            {{-- {!!App\Classes\Helper::zdjecianoweamp($art)!!} --}}
                        </a>
                    </div>
                    <div class="tytul">
                        <h2><a href="{{ Config::get('app.url') }}/{{$art->category->path.'/'.$art->alias.'.html'}}">{{ $art->title}}</a></h2>
                    </div>

                </div>
            @endif
        @endforeach
        </div>
        {{$articles->links()}}
    </div>
@endsection
