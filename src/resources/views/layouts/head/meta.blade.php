@if($type == "default")
    {{-- Jezeli to nie jest artykuł ani category --}}
    <title>SwiatRolnika.info - Portal rolniczy, rolnictwo, hodowla, żywność - informacje i porady </title>
    <meta name="description" content="Portal rolnika i informacje dla producentów. Żywność, środki ochrony roślin ubezpieczenia i odszkodowania rolnicze, produkcja rolna i przetwórstwo - to wszystko na portalu rolniczym ŚwiatRolnika.INFO" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <link href="https://swiatrolnika.info/amp" rel="amphtml"> --}}
    {{-- Jezeli to jest artykuł --}}
    {{-- && $article->category->title != 'Strony' --}}
@elseif($type == "article")
    <meta charset="UTF-8">
    <title>{{$article->title}}</title>
    <link rel="canonical" href="{{ Config::get('app.url') }}/{{$article->category->path}}/{{$article->alias}}.html">
    <link href="{{ Config::get('app.url') }}/{{$article->category->path}}/{{$article->alias}}.html/amp" rel="amphtml">
    @if ($mode == 'amp')
        <script async="" src="https://cdn.ampproject.org/v0.js"></script>
    @endif
    <meta name="description" content="{{App\Classes\Helper::metadescription($article)}}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="{{$article->user->name ?? ''}}">
    <meta name="image" content="{{asset(App\Classes\Images::orginalImagePath($article))}}">
    <link rel="preload" href="{{asset(App\Classes\Images::orginalImagePath($article))}}" as="image" media="(max-width: 412px)">

    {{-- Twiter --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ Config::get('app.url') }}/{{$article->category->path}}/{{$article->alias}}.html">
    <meta name="twitter:title" content="{{$article->title}}">
    <meta name="twitter:description" content="{{App\Classes\Helper::metadescription($article)}}" />
    <meta name="twitter:image" content="{{asset(App\Classes\Images::orginalImagePath($article))}}">
    <meta name="twitter:image:alt" content="{{$article->title}}">

    {{-- Og TAG FACEBOOK --}}
    <meta property="og:type" content="article">
    <meta property="fb:admins" content="100001221571332" />
    <meta property="fb:app_id" content="362016495521034" />
    <meta property="fb:page_id" content="244220876369755" />
    <meta property="og:locale" content="pl_PL">
    <meta property="og:url" content="{{ Config::get('app.url') }}/{{$article->category->path}}/{{$article->alias}}.html">
    <meta property="og:title" content="{{$article->title}}">
    <meta property="og:description" content="{{App\Classes\Helper::metadescription($article)}}" />
    <meta property="og:image" content="{{asset(App\Classes\Images::orginalImagePath($article))}}">
    <meta property="og:image:alt" content="{{$article->title}}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="675">
@elseif($type == "category")
    {{-- @dd($category); --}}
    <meta charset="UTF-8">
    <title>{{$category->title}}</title>
    <link rel="canonical" href="{{ Config::get('app.url') }}/{{$category->path}}.html">
    <link href="{{Config::get('app.url') }}/{{$category->path}}.html/amp" rel="amphtml">
    @if ($mode == 'amp')
        <script async="" src="https://cdn.ampproject.org/v0.js"></script>
    @endif
    <link rel="alternate" href="{{Config::get('app.url') }}/feed/{{$category->path}}" title="{{$category->name}}" type="application/rss+xml" />
    {{-- @dd($article); --}}
    <meta name="description" content="<?php echo htmlspecialchars($category->description); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Twiter --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ Config::get('app.url') }}/{{$category->path}}.html">
    <meta name="twitter:title" content="{{$category->title}}">
    <meta name="twitter:description" content="{{$category->description}}" />
    {{-- Og TAG FACEBOOK --}}
    <meta property="og:type" content="article">
    <meta property="og:locale" content="pl_PL">
    <meta property="og:url" content="{{ Config::get('app.url') }}/{{$category->path}}">
    <meta property="og:title" content="{{$category->title}}">
    <meta name="og:description" content="{{$category->description}}" />

@endif

