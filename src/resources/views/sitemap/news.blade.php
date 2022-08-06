<urlset xmlns:news="http://www.google.com/schemas/sitemap-news/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
   @foreach($articles as $article)
    <url>
        <loc>https://swiatrolnika.info/{{$article->category->path}}/{{$article->alias}}.html</loc>
        <news:news>
            <news:publication>
                <news:name>SwiatRolnika.info - Portal rolniczy, rolnictwo, hodowla, żywność - informacje i porady</news:name>
                <news:language>pl</news:language>
            </news:publication>
        <news:publication_date>{{date("Y-m-d", strtotime($article->publish_up))}}T{{date("H:i:s+01:00", strtotime($article->publish_up))}}</news:publication_date>
        <news:title>{{$article->title}}</news:title>
        <news:keywords>{{$article->keywords}}</news:keywords>
        </news:news>
    </url>
    @endforeach
</urlset>
