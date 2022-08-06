@extends('layouts.amp', ['type' => 'article', 'mode'=>'amp'])
@section('content')
{!!App\Classes\Helper::hits($article)!!}
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
    <div class="article">
        <div class="content-art">
            <div class="author">Autor: {{$article->user->name ?? ''}} {{ date("H:i:s d-m-Y", strtotime($article->publish_up)) }}</div>
            <h1>{{$article->title}}</h1>
            <div class="fotka">
                @if($filmik != "")
                    <div class="fotka">
                        <amp-youtube data-videoid="{{str_replace('/', '', $filmik)}}" layout="responsive" width="480" height="270"></amp-youtube>
                    </div>
                @else
                <div class="fotka">
                    {!!App\Classes\Images::ampImage($article)!!}
                </div>
                @endif
            </div>
            <div class="tresc">
                @php
                    $result = str_replace("\r\n",'', $article->fulltext);

                    // twitter
                    $re = '/\<div data-oembed-url="(.*)twitter.com(.*)status\/([0-9]*?)(.*)"(.*)<\/div>/mU';
                    $str = $result;
                    $subst = '<amp-twitter width="390" height="330" layout="responsive" data-tweetid="$3" data-cards="hidden"></amp-twitter>';
                    $result = preg_replace($re, $subst, $str);

                    // facebook
                    $re = '/\<div data-oembed-url="((.*)facebook\.com(.*)posts\/([0-9]*?))(.*)"(.*)<\/blockquote><\/div><\/div>/mU';
                    $str = $result;
                    $subst = '<amp-facebook width="552" height="303" layout="responsive" data-href="$1"></amp-facebook>';
                    $result = preg_replace($re, $subst, $str);

                    $re = '/\<div data-oembed-url="((.*)facebook\.com(.*)videos\/([0-9]*?))(.*)"(.*)<\/blockquote><\/div><\/div>/mU';
                    $str = $result;
                    $subst = '<amp-facebook width="552" height="303" layout="responsive" data-href="$1"></amp-facebook>';
                    $result = preg_replace($re, $subst, $str);

                    $re = '/\<div data-oembed-url="((.*)instagram\.com\/p\/(.*))(\/|\")(.*)"(.*)<\/script><\/div>/mU';
                    $str = $result;
                    $subst = '<amp-instagram data-shortcode="$3" data-captioned width="400" height="400" layout="responsive"></amp-instagram>';
                    $result = preg_replace($re, $subst, $str);

                    $re = '/\<div data-oembed-url="((.*)youtube\.com\/watch\?v=(.*))(\/|\")(.*)"(.*)<\/div>/mU';
                    $str = $result;
                    $subst = '<amp-youtube data-videoid="$3" layout="responsive" width="480" height="270" layout="responsive"></amp-youtube>';
                    $result = preg_replace($re, $subst, $str);

                    $re = '/\<img(.*)style="(.*)"(.*)>/mU';
                    $str = $result;
                    $subst = '<img$1$3>';
                    $result = preg_replace($re, $subst, $str);

                    $re = '/\<img(.*)>/mU';
                    $str = $result;
                    $subst = '<amp-img$1 width="960" height="540" layout="responsive"></amp-img>';
                    $result = preg_replace($re, $subst, $str);

                    $re = '/(\s)?style="(.*)"/mU';
                    $result = preg_replace($re, "", $result);
                @endphp
                <?php echo $result; ?>
            </div>

            @push('ampscripts')
                @if (Str::contains($result, 'amp-twitter'))
                    <script  async custom-element="amp-twitter" src="https://cdn.ampproject.org/v0/amp-twitter-0.1.js"></script>
                @endif
                @if (Str::contains($result, 'amp-facebook'))
                    <script  async custom-element="amp-facebook" src="https://cdn.ampproject.org/v0/amp-facebook-0.1.js"></script>
                @endif
                @if (Str::contains($result, 'amp-instagram'))
                    <script async custom-element="amp-instagram" src="https://cdn.ampproject.org/v0/amp-instagram-0.1.js"></script>
                @endif
                @if (Str::contains($result, 'amp-youtube') OR $filmik != "")
                    <script async custom-element="amp-youtube" src="https://cdn.ampproject.org/v0/amp-youtube-0.1.js"></script>
                @endif
            @endpush
        </div>
    </div>
@endsection
