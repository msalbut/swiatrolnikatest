<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
    @foreach ($articles as $article )
    <url>
        @php
            $categorypath = $article->category->path;
            //dd($categorypath);
        @endphp
        <loc>https://swiatrolnika.info/{{$categorypath}}/{{$article->alias}}.html</loc>
    </url>
@endforeach
@foreach ($categories as $category )
    <url>
        <loc>https://swiatrolnika.info/{{$category->path}}.html</loc>
    </url>
@endforeach
</urlset>
