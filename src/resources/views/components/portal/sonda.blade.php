@if($poll)
<div class="sonda">
    <div class="section3_top">
        <h4 class="section3_title">Sonda</h4>
        <div class="img">
            <img style="width: 100%; padding-right: 15px; padding-left: 15px;" src="{{ asset('storage/images/loga/sr-logo-czarne.svg') }}"
                            alt="logo swiatrolnika.info">
        </div>
    </div>
    <div class="moduletable">
        <div class="mod-sppoll">
            @php
                $votes = json_decode($poll->polls, true);
                $ile = count($votes)/2;
                $all = 0;
                for($i = 0; $i < $ile; $i++){
                    $all +=  $votes['votes_'.$i];
                }
            @endphp
            <strong>{{$poll->title}}</strong>
            @if(isset($_COOKIE[$poll->id]))
            <div>
                @for($i = 0; $i < $ile; $i++)
                    <div class="poll-result-item">
                        <div class="odpowiedzzglosami">
                            <div class="odpowiedzi">
                                {{$votes['answer_'.$i]}}
                            </div>
                            <div class="glosy">
                                {{$votes['votes_'.$i]}} Głosów
                            </div>
                        </div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar progress-bar-default" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em; {{'width:'.round($votes['votes_'.$i]/$all*100) .'%'}}">
                            {{round($votes['votes_'.$i]/$all*100) .'%'}}
                        </div>
                    </div>
                @endfor
            </div>
            @else
                <form action="{{route('glosuj')}}" method="post" class="form-poll" enctype="multipart/form-data">
                    @csrf
                    @for($i = 0; $i < $ile; $i++)
                        <div class="radio">
                            <input type="hidden" name="poll" value="{{$poll->id}}">
                            <input type="radio" name="vote" id="{{'input_'.$i}}" value="{{$i}}">
                            <label for="{{'input_'.$i}}">{{$votes['answer_'.$i]}}</label>
                        </div>
                    @endfor
                    <input type="submit" class="btn btn-default" value="Zagłosuj">
                </form>
            @endif
        </div>
    </div>
    <div class="sondt d-none d-sm-block">
        <div class="title-footer-sondt">Rolnicze wieści światrolnika.info w social mediach</div>
        <div class="socialmedia-sonda">
            <a href="https://www.facebook.com/SwiatRolnikainfo/" rel="nofollow"><img loading="lazy" src="{{ asset('storage/images/mobile/ikonka-fb.svg') }}" alt="facebook swiatrolnika.info"></a>
            <a href="https://www.instagram.com/swiatrolnika.info/" rel="nofollow"><img loading="lazy" src="{{ asset('storage/images/mobile/ikonka-instagram.svg') }}" alt="youtube swiatrolnika.info"></a>
            <a href="https://twitter.com/swiat_rolnika" rel="nofollow"><img loading="lazy" src="{{ asset('storage/images/mobile/ikonka-twitter.svg') }}" alt="twitter swiatrolnika.info"></a>
            <a href="https://www.youtube.com/channel/UC7iTON-_LCOCJVWt8gvExcA" rel="nofollow"><img loading="lazy" src="{{ asset('storage/images/mobile/ikonka-yt.svg') }}" alt="youtube swiatrolnika.info"></a>
        </div>
        <div class="logo-sonda">
            <img src="{{ asset('storage/images/loga/sr-logo-czarne-min.svg') }}" alt="logo swiatrolnika.info">
        </div>
    </div>
</div>
@endif
