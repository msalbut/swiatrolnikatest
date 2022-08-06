{{-- @dd($pilne) --}}
<section id="pilne">
    <div class="pasek-pilne">
        <div class="text_pilne">PILNE!</div>
        <div class="informacja">
            <a href="{{ Config::get('app.url') }}/{{$pilne->category->path}}/{{$pilne->alias}}.html">{{$pilne->title}}</a>
        </div>
    </div>
</section>
