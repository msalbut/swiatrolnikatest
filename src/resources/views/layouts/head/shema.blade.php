@if($type == "article")
@if($article->id == '28086')
    <script type="application/ld+json">
{
"@context": "https://schema.org",
"@type": "FAQPage",
"mainEntity": [{
"@type": "Question",
"name": "Jak rozpoznać mszycę i czym ona jest?",
"acceptedAnswer": {
"@type": "Answer",
"text": "Mszyca to niewielki owad o długości zwykle 1-2 mm. Posiada wydłużony i cienki tułów oraz duże odnóża"
}
},{
"@type": "Question",
"name": "Co powodują mszyce?",
"acceptedAnswer": {
"@type": "Answer",
"text": "W wyniku osłabienia rośliny możemy zaobserwować zahamowanie wzrostu i spadek poziomu plonowania."
}
},{
"@type": "Question",
"name": "Kiedy pojawiają się mszyce w sadach jabłoniowych?",
"acceptedAnswer": {
"@type": "Answer",
"text": "Mszyce w mogą pojawiać w sadach jabłoniowych na przełomie marca i kwietnia – wówczas też należy rozpocząć monitoring, aby w odpowiednim czasie wykonać zabieg insektycydowy."
}
}]
}
</script>
@endif
{{-- @dd($article); --}}
@php
    $publicationDate = $article->publish_up;
    $modyficationDate = $article->modified;
    // dd($article);
    $img = asset(App\Classes\Images::orginalImagePath($article));
    $description = App\Classes\Helper::metadescription($article);
@endphp
<script type="application/ld+json">
    {
        "@context": "http:\/\/schema.org",
        "@type": "NewsArticle",
        "mainEntityOfPage": "{{ Config::get('app.url') }}/{{$article->category->path}}/{{$article->alias}}.html",
        "headline": "{{$article->title}}",
        "datePublished": "{{date("Y-m-d", strtotime($publicationDate))}}T{{date("H:i", strtotime($publicationDate))}}Z",
        "dateModified": "{{date("Y-m-d", strtotime($publicationDate))}}T{{date("H:i:s", strtotime($publicationDate))}}Z",
        "image": {
            "@type": "ImageObject",
            "url": "{{ Config::get('app.url') }}/<?=$img;?>",
            "caption": "{{$article->alias}}",
            "width": "600",
            "height": "400"
        },
        "author": {
            "@type": "Person",
            "name": "{{$article->user->name ?? ''}}"
        },
        "publisher": {
            "@type": "Organization",
            "name": "Swiatrolnika.info",
            "logo": {
                "@type": "ImageObject",
                "url": "{{ Config::get('app.url') }}/storage/images/loga/sr-logo-czarne.svg",
                "width": 600,
                "height": 60
            }
        },
        "description": "{{$description}}"
    }
</script>

@elseif($type == "category")

<script type="application/ld+json">
    {
        "@context":"http://schema.org",
        "@type":"ItemList",
        "itemListElement":[
            @foreach($articles as $key => $article)
            @if($loop->last)
            {
                "@type":"ListItem",
                "position":{{++$key}},
                "url":"{{ Config::get('app.url') }}/{{$article->category->path}}/{{$article->alias}}.html"
            }
            @else
            {
                "@type":"ListItem",
                "position":{{++$key}},
                "url":"{{ Config::get('app.url') }}/{{$article->category->path}}/{{$article->alias}}.html"
            },
            @endif
            @endforeach
        ]
    }
    </script>
@endif
