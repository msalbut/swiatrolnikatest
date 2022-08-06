<nav id="mymenu" class="green">
    <ol class="nav menu mod-list">
        @foreach ($menu as $menuLink)
            <li class="item-227 active deeper parent">
                <a href="/{{$menuLink->category->path}}.html">{{$menuLink->category->title}}</a>
                <ul class="nav-child unstyled">
                    @foreach ($menuLink->children as $childMenuLink)
                        <li class="item-228">
                            <a href="/{{ $childMenuLink->category->path }}.html">{{$childMenuLink->category->title}}</a>
                        </li>
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ol>
</nav>
