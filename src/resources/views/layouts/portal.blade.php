@php
    $type = $type ?? 'default';
    $mode = $mode ?? 'normal';
@endphp
<!DOCTYPE html>
<html lang="pl">

<head>
    @include('layouts.head.head')
</head>

<body>
    <x-portal.pilne />
    <x-portal.header :type="$type" :mode="$mode" />
    <x-portal.menu />
    <div class="kontener-glowny">
        @yield('content')
    </div>
    <footer id="sekcja11">
        <x-portal.footer :type="$type" :mode="$mode" />
    </footer>
    <script>
        var burgerMenu = document.getElementById('burger-menu');
        var overlay = document.getElementById('mymenu');
        burgerMenu.addEventListener('click',function(){
        this.classList.toggle("close");
        overlay.classList.toggle("overlay");
        });
    </script>
<script async charset="utf-8" src="https://platform.twitter.com/widgets.js"></script>
    <script type="text/javascript">
    const lazyLoad = new class LazyLoad {
    constructor() {
        this.lazyImages = document.querySelectorAll('.lazy');

        this.lazyloadThrottleTimeout;
    }
    // Lazy load for Chrome & FF
    intersector() {
        const imageObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
            let image = entry.target;
            image.src = image.dataset.src;
            image.classList.remove('lazy');
            imageObserver.unobserve(image);
            }
        });
        }, {
        rootMargin: '0px 0px -50px 0px'
        });

        this.lazyImages.forEach((image) => {
        imageObserver.observe(image);
        });
    }
    // Lazy load for Safari
    safariLazyLoad() {
        const lazyImages = document.querySelectorAll('.lazy');

        if (this.lazyloadThrottleTimeout) {
        clearTimeout(this.lazyloadThrottleTimeout);
        }
        this.lazyloadThrottleTimeout = setTimeout(() => {
        let top = window.scrollY;
        lazyImages.forEach((image) => {
            if (top > image.offsetTop - 50) {
            image.src = image.dataset.src;
            image.classList.remove('lazy');
            }
        });
        }, 20);
    }
    }
        'IntersectionObserver' in window ? lazyLoad.intersector() :
        document.onscroll = lazyLoad.safariLazyLoad,
        window.addEventListener('resize', lazyLoad.safariLazyLoad),
        window.addEventListener('orientationChange', lazyLoad.safariLazyLoad);
    </script>
    @stack('script')
</body>
</html>
