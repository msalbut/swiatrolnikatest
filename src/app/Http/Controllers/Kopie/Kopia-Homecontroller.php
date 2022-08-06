<?php 
    public function showkat($alias){
        $cat = explode('.', $alias);//rozbij to co jest w wpisane w adresie po / po .
        $catcount = count($cat); //sprawdz ile jest zliczonych elementow
        $kategorie = Category::get();
        $kategoria = Category::where('alias', $cat[0])->first(); //wyciągnij kategorie po aliasie
        if($kategoria AND $catcount <= 1){ //jeżeli w zmiennej catcount jest jeden element i znajdzie kategorie
            return redirect('/'.$cat[0].'.html'); // przekieruj użytkownika na poprawny link z dopiskiem .html
        }
        elseif($kategoria AND $catcount > 1 AND $cat[1] != 'html'){ //jeżeli znajdzie kategorie i w adresie jest alias.*(cos innego niz html)
            return redirect('/'.$cat[0].'.html');
        }
        elseif($kategoria AND $catcount > 1 AND $cat[1] == 'html'){ //jeżeli znajdzie kategorie i w adresie jest alias.html
            if($kategoria->level == 1){
                $categories = Category::select('id')->where('parent_id', $kategoria->id)->orWhere('id', $kategoria->id)->get()->pluck('id')->toArray();
                $articles = Content::where('state', '1')->where('publish_up', '<', $this->today)->whereIN('catid', $categories)->orWhereIn('id', $kategoria->contents->pluck('id'))->with('User')->with('category')->latest()->paginate(13); //pobierz artykuły z danej kategorii i podkategorii
                // dd($articles);
                return view('portal.category', compact('articles', 'kategoria', 'kategorie'));
            }
        }
        else{ //jeżeli w linku po / nie ma aliasu kategorii
            $article = Content::with('User')->with('category')->where('publish_up', '<', $this->today)->where('state', '1')->where('alias', $cat[0])->first(); // wyciągnij artykuł po aliasie
            if($article AND $article->category->path != 'strony'){ //jeżeli jest artykuł i jego kategoria jest inna niż "strony"
                return redirect('/'.$article->category->path.'/'.$cat[0].'.html'); //przekieruj na poprawny link
            }
            elseif($catcount <= 1 AND $article AND $article->category->path == 'strony'){ //jeżeli znajdzie artykuł i kategoria to "strony", ale bez dopisku html
                return redirect('/'.$cat[0].'.html'); // przekieruj na dobry adres
            }
            elseif($catcount > 1 AND $article AND $article->category->path == 'strony' AND $cat[1] != 'html'){ //jeżeli znajdzie artykuł i kategoria to "strony", ale po . jest co innego niż dopisku html
                return redirect('/'.$cat[0].'.html');//przekieruj na poprawny adres
            }
            elseif($catcount > 1 AND $article AND $article->category->path == 'strony' AND $cat[1] == 'html'){ //jeżeli znajdzie artykuł i kategoria to "strony", a po .html
                $metadescription = Helper::metadescription($article);
                $article->update(['hits' => $article->hits]);
                return view('portal.article', compact('article', 'metadescription'));//wyświetl widok artykułu
            }
            elseif($catcount <= 1){ //jeżeli nie znajdzie artykułu ani kategorii
                 return redirect('/'.$alias.'.html');//przekieruj na strone z błędem
            }
            else {//jeśli nic nie znajdzie a struktura linku jest poprawna
                // return view('error.404');//wyświetl strone z błędem
                return redirect('/');//przekieruj na strone główną
            }
        }
    }
    public function showkatamp($alias){
        $cat = explode('.', $alias);//rozbij to co jest w wpisane w adresie po / po .
        $catcount = count($cat); //sprawdz ile jest zliczonych elementow
        $kategoria = Category::where('alias', $cat[0])->first(); //wyciągnij kategorie po aliasie
        if($kategoria AND $catcount <= 1){ //jeżeli w zmiennej catcount jest jeden element i znajdzie kategorie
            return redirect('/'.$cat[0].'.html'); // przekieruj użytkownika na poprawny link z dopiskiem .html
        }
        elseif($kategoria AND $catcount > 1 AND $cat[1] != 'html'){ //jeżeli znajdzie kategorie i w adresie jest alias.*(cos innego niz html)
            return redirect('/'.$cat[0].'.html');
        }
        elseif($kategoria AND $catcount > 1 AND $cat[1] == 'html'){ //jeżeli znajdzie kategorie i w adresie jest alias.html
            if($kategoria->level == 1){
                $categories = Category::select('id')->where('parent_id', $kategoria->id)->orWhere('id', $kategoria->id)->with('parent')->get()->pluck('id')->toArray();
                $articles = Content::where('state', '1')->where('publish_up', '<', $this->today)->whereIN('catid', $categories)->orWhereIn('id', $kategoria->contents->pluck('id'))->with('User')->with('category')->latest()->paginate(13); //pobierz artykuły z danej kategorii i podkategorii
                // dd($articles);
                return view('portal.categoryamp', compact('articles', 'kategoria'));
            }
        }
        else{ //jeżeli w linku po / nie ma aliasu kategorii
            $article = Content::with('User')->with('category')->where('publish_up', '<', $this->today)->where('state', '1')->where('alias', $cat[0])->first(); // wyciągnij artykuł po aliasie
            if($article AND $article->category->path != 'strony'){ //jeżeli jest artykuł i jego kategoria jest inna niż "strony"
                return redirect('/'.$article->category->path.'/'.$cat[0].'.html'); //przekieruj na poprawny link
            }
            elseif($catcount <= 1 AND $article AND $article->category->path == 'strony'){ //jeżeli znajdzie artykuł i kategoria to "strony", ale bez dopisku html
                return redirect('/'.$cat[0].'.html'); // przekieruj na dobry adres
            }
            elseif($catcount > 1 AND $article AND $article->category->path == 'strony' AND $cat[1] != 'html'){ //jeżeli znajdzie artykuł i kategoria to "strony", ale po . jest co innego niż dopisku html
                return redirect('/'.$cat[0].'.html');//przekieruj na poprawny adres
            }
            elseif($catcount > 1 AND $article AND $article->category->path == 'strony' AND $cat[1] == 'html'){ //jeżeli znajdzie artykuł i kategoria to "strony", a po .html
                $metadescription = Helper::metadescription($article);
                $article->update(['hits' => $article->hits]);
                return view('portal.article', compact('article', 'metadescription'));//wyświetl widok artykułu
            }
            elseif($catcount <= 1){ //jeżeli nie znajdzie artykułu ani kategorii
                 return redirect('/'.$alias.'.html');//przekieruj na strone z błędem
            }
            else {//jeśli nic nie znajdzie a struktura linku jest poprawna
                // return view('error.404');//wyświetl strone z błędem
                return redirect('/');//przekieruj na strone główną
            }
        }
    }

    public function showartcategory($kat1, $alias){
        $cat = explode('.', $alias);//rozbij to co jest w wpisane w adresie po / po .
        $catcount = count($cat);//sprawdz ile jest zliczonych elementow
        $kategoria = Category::where('alias', $cat[0])->with('parent')->first();//wyciągnij kategorie po aliasie
        $kategorie = Category::get();
        // dd($kategoria->contents->pluck('id'));
        if($kategoria){//sprawdź czy udało się wyciągnąć kategorie
            if($catcount <= 1){//sprawdź czy w linku jest dopisek po .
                return redirect('/'.$kategoria->path.'.html');//przekieruj na strone o poprawnym adresie
            }
            elseif($catcount > 1 AND $cat[1] != 'html'){//jeśli struktura linku jest poprawna ale po . jest coś innego nic .html przekieruj na poprawny adres
                return redirect('/'.$kategoria->path.'.html');//przekieruj na strone o poprawnym adresie
            }
            else {
                $articles = Content::where('state', '1')->where('publish_up', '<', $this->today)->where('catid', $kategoria->id)->orWhereIn('id', $kategoria->contents->pluck('id'))->with('User')->with('category')->latest()->paginate(13);
                return view('portal.category', compact('articles', 'kategoria', 'kategorie'));//wyświetl widok kategorii
            }
        }
        else{//jeżeli nie znajdzie kategorii po aliasie
            $article = Content::with('User')->with('category')->where('publish_up', '<', $this->today)->where('state', '1')->where('alias', $cat[0])->first();//sprawdz czy jest artykuł o takim aliasie
                if($article AND $article->category->path != 'strony'){//jeśli jest i jego kategoria jes inna niż "strony"
                    if($catcount <= 1){//jeśli w linku nie ma dopisku po .
                        return redirect('/'.$article->category->path.'/'.$cat[0].'.html'); // przekieruj na poprawny adres
                    }
                    elseif($catcount > 1 AND $cat[1] != 'html'){//jeżeli w linku jest dopisek po . ale jest inny niż html
                        return redirect('/'.$article->category->path.'/'.$cat[0].'.html');//przekieruj na poprawna strone
                    }
                    elseif($catcount > 1 AND $cat[1] == 'html' AND $article->category->level == 1){ //jeżeli adres jest poprawny a kategoria jest poziomu 1
                        $propozycje = Content::with('User')->with('category')->where('catid', $article->catid)->where('publish_up', '<', $this->today)->where('state', '1')->where('id', '!=', $article->id)->orderByDesc('publish_up')->take(3)->get();
                        // dd($propozycje);
                        $article->update(['hits' => $article->hits]);
                        $metadescription = Helper::metadescription($article);
                        return view('portal.article', compact('article', 'metadescription', 'propozycje'));//wyswietl artykuł
                    }
                }
                elseif($catcount <= 1 AND $article AND $article->category->path == 'strony'){//sprawdzenie czy jest art, czy nie nalezy do kategorii "strony" oraz czy nie ma dopisku po .
                    return redirect('/'.$cat[0].'.html');//przekierowuje na poprawna strone
                }
                elseif($catcount > 1 AND $article AND $article->category->path == 'strony'){//jesli jest artykuł i dopisek html + art nalezy do kategorii "strony"
                    return redirect('/'.$cat[0].'.html');//przekierowuje na poprawny adres
                }
                elseif(!$article) {//Jesli nie ma artykułu ani kategorii z parametru 2
                    $kategoria = Category::where('alias', $kat1)->first();//wyciagnij kategorie z parametru 1
                    if($kategoria){//jesli jest
                        return redirect('/'.$kategoria->path.'.html');//przekieruj na odpowiednia strone
                    }
                    elseif ($catcount <= 1) { //sprawdz czy jest dopisek po .
                        return redirect('/'.$kat1.'/'.$cat[0].'.html'); //przekieruj na odpowiednia strone
                    }
                    elseif ($catcount > 1) {//jesli zaden warunek nie zostanie spełniony a stryktura linku jest prawidłowa
                        // return view('error.404'); // wyświetl strone z błędem
                        return redirect('/');//przekieruj na strone główną
                    }
                }
            }
        }




    public function showart($kat1, $kat2, $alias)
    {
        $alias = explode('.', $alias); //rozbij to co jest w wpisane w adresie po / po .
        $aliascount = count($alias);//sprawdz ile jest zliczonych elementow
        $article = Content::with('User')->with('category.parent')->where('state', '1')->where('publish_up', '<', $this->today)->where('alias', $alias[0])->first();
        // dd($propozycje);
        if($article){
            $propozycje = Content::with('User')->with('category.parent')->where('publish_up', '<', $this->today)->where('catid', $article->catid)->where('state', '1')->where('id', '!=', $article->id)->orderByDesc('publish_up')->take(3)->get();
            $userpath = $kat1."/".$kat2;
            if($userpath != $article->category->path OR $aliascount == 1){
                return redirect('/'.$article->category->path.'/'. $alias[0].'.html');
            }
            else{
                $metadescription = Helper::metadescription($article);
                $article->update(['hits' => $article->hits]);
                return view('portal.article', compact('article', 'metadescription', 'propozycje'));
            }
        }
        else{
            if ($aliascount <= 1) { //sprawdz czy jest dopisek po .
                return redirect('/'.$kat1.'/'.$kat2.'/'.$alias[0].'.html'); //przekieruj na odpowiednia strone
            }
            elseif ($aliascount > 1) {//jesli zaden warunek nie zostanie spełniony a struktura linku jest prawidłowa
                // return view('error.404'); // wyświetl strone z błędem
                return redirect('/');//przekieruj na strone główną
            }
        }
    }
    public function showartamp($kat1, $kat2, $alias)
    {
        $alias = explode('.', $alias); //rozbij to co jest w wpisane w adresie po / po .
        $aliascount = count($alias);//sprawdz ile jest zliczonych elementow
        $article = Content::with('User')->with('category.parent')->where('state', '1')->where('publish_up', '<', $this->today)->where('alias', $alias[0])->first();
        if($article){
            $propozycje = Content::with('User')->with('category.parent')->where('publish_up', '<', $this->today)->where('catid', $article->catid)->where('state', '1')->where('id', '!=', $article->id)->orderByDesc('publish_up')->take(3)->get();
            $article->update(['hits' => $article->hits]);
            $userpath = $kat1."/".$kat2;
            if($userpath != $article->category->path OR $aliascount == 1){
                return view('portal.articleamp', compact('article', 'userpath', 'alias', 'propozycje'));
                //return redirect('/'.$article->category->path.'/'. $alias[0].'.amp.html');
            }
            else{
                return view('portal.articleamp', compact('article'));
            }
        }
        else{
            if ($aliascount <= 1) { //sprawdz czy jest dopisek po .
                return redirect('/'.$kat1.'/'.$kat2.'/'.$alias[0].'.amp.html'); //przekieruj na odpowiednia strone
            }
            elseif ($aliascount > 1) {//jesli zaden warunek nie zostanie spełniony a struktura linku jest prawidłowa
                // return view('error.404'); // wyświetl strone z błędem
                return redirect('/');//przekieruj na strone główną
            }
        }
    }
    public function showartampone($kat1, $alias)
    {
        $alias = explode('.', $alias); //rozbij to co jest w wpisane w adresie po / po .
        $aliascount = count($alias);//sprawdz ile jest zliczonych elementow
        $article = Content::with('User')->with('category.parent')->where('state', '1')->where('publish_up', '<', $this->today)->where('alias', $alias[0])->first();
        if($article){
            $propozycje = Content::with('User')->with('category.parent')->where('catid', $article->catid)->where('publish_up', '<', $this->today)->where('state', '1')->where('id', '!=', $article->id)->orderByDesc('publish_up')->take(3)->get();
            $userpath = $kat1;
            $article->update(['hits' => $article->hits]);
            if($userpath != $article->category->path OR $aliascount == 1){
                return view('portal.articleamp', compact('article', 'userpath', 'alias', 'propozycje'));
                //return redirect('/'.$article->category->path.'/'. $alias[0].'.amp.html');
            }
            else{
                return view('portal.articleamp', compact('article'));
            }
        }
        else{
            if ($aliascount <= 1) { //sprawdz czy jest dopisek po .
                return redirect('/'.$kat1.'/'.$alias[0].'.amp.html'); //przekieruj na odpowiednia strone
            }
            elseif ($aliascount > 1) {//jesli zaden warunek nie zostanie spełniony a struktura linku jest prawidłowa
                // return view('error.404'); // wyświetl strone z błędem
                return redirect('/');//przekieruj na strone główną
            }
        }
    }
    /*
     ***************************************************************
     ****************************************************************
     ****************************************************************
        Funkcje pomocnicze do uporządkowania zdjęć
     ****************************************************************
     ****************************************************************
     ****************************************************************
     */
    public function movephototonewpath($od, $do)
    {
        $content = Content::where('id', '>', $od)->where('id', '<', $do)->get();
        // dd($content);
        //5499 / 6000
        // 22000 / 22685
        foreach ($content as $key => $art) {
            if (isset(json_decode($art->images, true)['image_intro']) AND json_decode($art->images, true)['image_intro'] != "") {
                if (json_decode($art->images, true)['image_intro_alt'] == "") {
                    $alt = $art->title;
                } else {
                    $alt = json_decode($art->images, true)['image_intro_alt'];
                }
                $nazwa = explode("/", json_decode($art->images, true)['image_intro']);
                if(is_null($art->publish_up)){
                    $dateyear = date("Y", strtotime($art->created_at));
                    $datemouth = date("m", strtotime($art->created_at));
                    $dateday = date("d", strtotime($art->created_at));
                    // $newpath = 'public/images/article/'.date("Y", strtotime($art->created_at)).'/'.date("m", strtotime($art->created_at)).'/'.date("d", strtotime($art->created_at)).'/'.end($nazwa);
                }else{
                    $dateyear = date("Y", strtotime($art->created_at));
                    $datemouth = date("m", strtotime($art->created_at));
                    $dateday = date("d", strtotime($art->created_at));
                }
                $newpath = 'public/images/article/orginal/' . $dateyear . '/' . $datemouth . '/' . $dateday . '/' . end($nazwa);
                $oldpath = 'public/'.json_decode($art->images, true)['image_intro'];
                $pathtoresize = 'storage/' . json_decode($art->images, true)['image_intro'];
                $pathforrezise = $dateyear . '/' . $datemouth . '/' . $dateday . '/' . end($nazwa);
                if (!File::exists(public_path('storage/images/article/desktop/' . $dateyear . '/' . $datemouth . '/' . $dateday . '/'))) {
                    File::makeDirectory(public_path('storage/images/article/desktop/' . $dateyear . '/' . $datemouth . '/' . $dateday . '/'), 0777, true, true);
                }
                if (!File::exists(public_path('storage/images/article/tablet/' . $dateyear . '/' . $datemouth . '/' . $dateday . '/'))) {
                    File::makeDirectory(public_path('storage/images/article/tablet/' . $dateyear . '/' . $datemouth . '/' . $dateday . '/'), 0777, true, true);
                }
                if (!File::exists(public_path('storage/images/article/smartphone/' . $dateyear . '/' . $datemouth . '/' . $dateday . '/'))) {
                    File::makeDirectory(public_path('storage/images/article/smartphone/' . $dateyear . '/' . $datemouth . '/' . $dateday . '/'), 0777, true, true);
                }
                if (Storage::exists($oldpath)) {
                    $resize = Image::make($pathtoresize);
                    $desktopimage = Image::make($resize)->fit(960, 540);
                    // dd($desktopimage->basename);
                    $tabletimage = Image::make($resize)->fit(640, 360);
                    $smartphoneimage = Image::make($resize)->fit(480, 270);
                    $desktopimage->save('storage/images/article/desktop/' . $pathforrezise);
                    $tabletimage->save('storage/images/article/tablet/' . $pathforrezise);
                    $smartphoneimage->save('storage/images/article/smartphone/' . $pathforrezise);

                    // $newpath = 'public/images/article/' . $dateyear . '/' . $datemouth . '/' . $dateday . '/' . end($nazwa);
                    if (Storage::exists($newpath)){
                        // Storage::copy($oldpath, $newpath);
                    }else{
                        Storage::copy($oldpath, $newpath);
                    }
                }
                else{}
                ContentImage::create([
                    'content_id' => $art->id,
                    'type' => 'desktop',
                    'path' => 'storage/images/article/desktop/' . $pathforrezise,
                    'alt' => $alt,
                ]);
                ContentImage::create([
                    'content_id' => $art->id,
                    'type' => 'tablet',
                    'path' => 'storage/images/article/tablet/' . $pathforrezise,
                    'alt' => $alt,
                ]);
                ContentImage::create([
                    'content_id' => $art->id,
                    'type' => 'smartphone',
                    'path' => 'storage/images/article/smartphone/' . $pathforrezise,
                    'alt' => $alt,
                ]);
                echo $art->id.'<br>';
                }else{
                    ContentWithoutImage::create([
                    'content_id' => $art->id,
                    ]);
                    echo 'How: '.$art->id.'<br>';
                }
            }
            return 'success';
        }
    public function findimagefromtext($od, $do){
        $re = '/src="(.*)"/mU';
        $content = Content::where('id', '>', $od)->where('id', '<', $do)->get();
        foreach ($content as $key => $art){
            $str = $art->fulltext;
            preg_match_all($re, $str, $matches, PREG_SET_ORDER, 0);
            if(count($matches)>0){
                $nazwa = explode('/', $matches[0][1]);
                $oldpath = 'public/' . $matches[0][1];
                $pathtoresize = 'storage/' . $matches[0][1];
                if (is_null($art->publish_up)) {
                    $dateyear = date("Y", strtotime($art->created_at));
                    $datemouth = date("m", strtotime($art->created_at));
                    $dateday = date("d", strtotime($art->created_at));
                } else {
                    $dateyear = date("Y", strtotime($art->publish_up));
                    $datemouth = date("m", strtotime($art->publish_up));
                    $dateday = date("d", strtotime($art->publish_up));
                }
                if (!File::exists(public_path('storage/images/imagesincontent/'.$dateyear.'/'.$datemouth.'/'.$dateday.'/'))) {
                    File::makeDirectory(public_path('storage/images/imagesincontent/'.$dateyear.'/'.$datemouth.'/'.$dateday.'/'), 0777, true, true);
                }
                $path = 'images/imagesincontent/' . $dateyear . '/' . $datemouth . '/' . $dateday . '/' . end($nazwa);
                $newpathintext = '/storage/' . $path;
                if (Storage::exists($oldpath)) {
                    $resize = Image::make($pathtoresize);
                    $desktopimage = Image::make($resize)->fit(960, 540);
                    $desktopimage->save('storage/'.$path);
                    $newpath = 'public/images/orginalimagesincontent/' . $dateyear . '/' . $datemouth . '/' . $dateday . '/' . end($nazwa);
                    if (Storage::exists($newpath)) {
                    } else {
                        Storage::copy($oldpath, $newpath);
                    }
                }
                $zmienione = str_replace($matches[0][1], $newpathintext, $art->fulltext);
                $art->update(['fulltext' => $zmienione]);
                echo $art->id.'<br>';

        }
    }
    // echo "Przekopiowanych ".$key." zdjęć<br>";
    return 'succes artykuły'.$od.'do'.$do;
}
}
