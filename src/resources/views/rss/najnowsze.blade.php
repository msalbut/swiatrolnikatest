<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:media="http://search.yahoo.com/mrss/">
    <channel>
    <title>SwiatRolnika.info - Portal rolniczy, rolnictwo, hodowla, żywność - informacje i porady </title>
    <link>https://swiatrolnika.info</link>
    <description><![CDATA[]]></description>
    <language>pl</language>
    <generator>RSS::ŚwiatRolnika.info</generator>
    <ttl>5</ttl>
    <atom:link href='https://swiatrolnika.info/feed/najnowsze/' rel="self" type="application/rss+xml" />
    <image>
    <title>Najnowsze</title>
    <url>https://swiatrolnika.info/templates/wsensie2018/favicon.ico</url>
    <link>https://swiatrolnika.info/</link>
    <width>80</width>
    <height>80</height>
    </image>
    <?php foreach($articles as $article)
    {
        // $tnij = strip_tags($article->fulltext);
        // if(strlen($tnij) > 300) {
        //     $wstep = substr($tnij, 0, 300);
        // }else {
        //     $wstep = $tnij;
        // }
        // dd($wstep);
        $wstep = $article->fulltext;
    $start = strpos($wstep, '<p>');
    $end = strpos($wstep, '</p>', $start);
    $lead = substr($wstep, $start, $end - $start + 4);
    $lead = str_replace('<p>', '', $lead);
    $lead = str_replace('</p>', '', $lead);

    $description = substr($lead, 0, 300);

    $length = max([
        strrpos($description, '.', -1),
        strrpos($description, '?', -1),
        strrpos($description, '!', -1)
    ]);

    $description = substr($lead, 0, $length + 1);
    $image = json_decode($article->images, true);
    if(isset($image["image_intro"])) {
                    $nazwa = explode("/", $image["image_intro"]);
                    }else {
                        $nazwa = array();
                    }


        echo'
        <item>
    <title><![CDATA['.$article->title.']]></title>
    <link>https://swiatrolnika.info/'.$article->category->path.'/'.$article->alias.'.html</link>

    <description>
    <![CDATA[
    '.$description.'<img type="image/jpeg" src="https://swiatrolnika.info/images/mobilne/tablety/m_'.end($nazwa).'" width="400" />
    ]]>
    </description>
    <pubDate>'. date('D, d M Y H:i:s', strtotime($article->publish_up)).' +0100</pubDate>
    <category>'.$article->category->name.'</category>
    <enclosure type="image/jpeg" url="https://swiatrolnika.info/'.App\Classes\Images::orginalImagePath($article).'" length="67328" />
    <guid>https://swiatrolnika.info/'.$article->category->path.'/'.$article->alias.'.html</guid>
    </item>';
    } ?>
    </channel>

    </rss>
