<header id="mainheader">
    <div class="logo-zdj-haslo">
        @if ($mode == 'amp')
            <a href="/" class="logo">
                <div class="amp_sitelogo">
                    <amp-img src="{{ asset('storage/images/loga/sr-logo-czarne.svg') }}" alt="logo swiatrolnika.info" width="450" height="40" layout="fixed"></amp-img>
                </div>
            </a>
            <div class="social-and-hamburger">
                <div class="social-media">
                    <a href="https://www.facebook.com/SwiatRolnikainfo/" rel="nofollow"><img loading="lazy" width="30px"
                            height="30px" src="{{ asset('storage/images/mobile/ikonka-fb.svg') }}"
                            alt="facebook swiatrolnika.info"></a>
                    <a href="https://www.instagram.com/swiatrolnika.info/" rel="nofollow"><img loading="lazy" width="30px"
                            height="30px" src="{{ asset('storage/images/mobile/ikonka-instagram.svg') }}"
                            alt="youtube swiatrolnika.info"></a>
                    <a href="https://twitter.com/swiat_rolnika" rel="nofollow"><img loading="lazy" width="30px"
                            height="30px" src="{{ asset('storage/images/mobile/ikonka-twitter.svg') }}"
                            alt="twitter swiatrolnika.info"></a>
                    <a href="https://www.youtube.com/channel/UC7iTON-_LCOCJVWt8gvExcA" rel="nofollow"><img loading="lazy"
                            width="30px" height="30px" src="{{ asset('storage/images/mobile/ikonka-yt.svg') }}"
                            alt="youtube swiatrolnika.info"></a>
                </div>
                <div class="hamburger_wrapper">
                    <div id="hamburger" tabindex="1" role="button" on="tap:hamburger.toggleClass(class='close'),nav-menu.toggleClass(class='now-active')">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
            <p class="haslo">Portal rolniczy - porady dla rolnika - informacje agro</p>
        @elseif($type == 'article' AND $mode == 'normal')
            <div class="logozdjecie">
                <a href="/" class="logo">
                    {{-- <img width="300" height="43" src="{{ asset('storage/images/loga/sr-logo-czarne.svg') }}/storage/images/loga/sr-logo-czarne.svg" alt="logo swiatrolnika.info"> --}}
                    <img width="300" height="43" src="{{ asset('storage/images/loga/sr-logo-czarne.svg') }}" alt="logo swiatrolnika.info">
                </a>
            </div>
             <div class="haslo">
                <div class="social-media">
                    <a href="https://www.facebook.com/SwiatRolnikainfo/" rel="nofollow"><img loading="lazy" width="30px"
                            height="30px" src="{{ asset('storage/images/mobile/ikonka-fb.svg') }}"
                            alt="facebook swiatrolnika.info"></a>
                    <a href="https://www.instagram.com/swiatrolnika.info/" rel="nofollow"><img loading="lazy" width="30px"
                            height="30px" src="{{ asset('storage/images/mobile/ikonka-instagram.svg') }}"
                            alt="youtube swiatrolnika.info"></a>
                    <a href="https://twitter.com/swiat_rolnika" rel="nofollow"><img loading="lazy" width="30px"
                            height="30px" src="{{ asset('storage/images/mobile/ikonka-twitter.svg') }}"
                            alt="twitter swiatrolnika.info"></a>
                    <a href="https://www.youtube.com/channel/UC7iTON-_LCOCJVWt8gvExcA" rel="nofollow"><img loading="lazy"
                            width="30px" height="30px" src="{{ asset('storage/images/mobile/ikonka-yt.svg') }}"
                            alt="youtube swiatrolnika.info"></a>
                </div>
                <div id="burger-menu">
                    <span></span>
                </div>
                <p>Portal rolniczy - porady dla rolnika - informacje agro</p>
            </div>
        @else
            <div class="logozdjecie">
                <a href="/" class="logo">
                    <img width="300" height="43" src="{{ asset('storage/images/loga/sr-logo-czarne.svg') }}" alt="logo swiatrolnika.info">
                </a>
            </div>
            <div class="haslo">
                <div class="social-media">
                    <a href="https://www.facebook.com/SwiatRolnikainfo/" rel="nofollow"><img loading="lazy" width="30px"
                            height="30px" src="{{ asset('storage/images/mobile/ikonka-fb.svg') }}"
                            alt="facebook swiatrolnika.info"></a>
                    <a href="https://www.instagram.com/swiatrolnika.info/" rel="nofollow"><img loading="lazy" width="30px"
                            height="30px" src="{{ asset('storage/images/mobile/ikonka-instagram.svg') }}"
                            alt="youtube swiatrolnika.info"></a>
                    <a href="https://twitter.com/swiat_rolnika" rel="nofollow"><img loading="lazy" width="30px"
                            height="30px" src="{{ asset('storage/images/mobile/ikonka-twitter.svg') }}"
                            alt="twitter swiatrolnika.info"></a>
                    <a href="https://www.youtube.com/channel/UC7iTON-_LCOCJVWt8gvExcA" rel="nofollow"><img loading="lazy"
                            width="30px" height="30px" src="{{ asset('storage/images/mobile/ikonka-yt.svg') }}"
                            alt="youtube swiatrolnika.info"></a>
                </div>
                <div id="burger-menu">
                    <span></span>
                </div>
                <h1>Portal rolniczy - porady dla rolnika - informacje agro</h1>
            </div>
        @endif
    </div>
</header>

