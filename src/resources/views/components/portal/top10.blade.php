<div class="topka">
    <div class="moduletable">
        <div class="category-module">
            <div class="najczestsze">
                <div class="akt">
                    <h4 id="top10">Top 10 Najczęściej czytane</h4>
                    <div
                        style="width: 50%; height: 46px; background: #F5F5F5; border-left: 27px solid #00A143; display: flex; align-items: center; flex-grow: 1;">
                        <img style="width: 100%; padding-right: 20px; padding-left: 15px;" src="{{ asset('storage/images/loga/sr-logo-czarne.svg') }}"
                            alt="logo swiatrolnika.info">
                    </div>
                </div>
                @foreach($toparticle as $key => $article)
                <div class="rowek1">
                    <div class="box51">
                        <div class="tyt3">
                            <div class="ty4">
                                <h3 style="min-height: 1px;"><a
                                        href="{{ Config::get('app.url') }}/{{ $article->category->path.'/'.$article->alias }}.html">{{$article->title}}</a></h3>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>
</div>
