<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Polls;
use App\Models\Content;
use App\Models\Category;
use App\Models\Image;
use App\Models\ImageNew;
use App\Models\Configuration;
use Illuminate\Support\Facades\File;
use Arr;
// use File;
use Intervention\Image\ImageManagerStatic as ImageManager;
use App\Classes\Helper;

// use Intervention\Image\ImageManagerStatic as Image;
// use App\Models\Image as ContentImage;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $config = Configuration::whereIn('type', ['module', 'other_module'])->orderBy('position')->get();
        $sprawdz = Content::where('alarm', 1)->published()->orderBy('publish_up', 'desc')->first();
        return view('portal.home', compact('config', 'sprawdz'));
    }
    public function show($adress){
        $adress = explode('/', $adress);
        $adress = array_map(function ($val) {
            return explode('?', $val)[0];
        }, $adress);
        $adress = array_map(function ($val) {
            return explode('.', $val);
        }, $adress);

        $requestUri = explode('?',  $_SERVER['REQUEST_URI'])[0];

        $adress = Arr::flatten($adress);
        $article = Content::with('User')->with('category')->published()->whereIn('alias', $adress)->first(); // wyciągnij artykuł po aliasie
        $category = Category::whereIn('alias', $adress)->where('published', 1)->orderByDesc('level')->first();
        if ($article) {
            if (in_array('amp', $adress) AND $requestUri != '/' . $article->category->path . '/' . $article->alias . '.html/amp') {
                return redirect('/' . $article->category->path.'/'.$article->alias . '.html/amp');
            }
            elseif (in_array('amp', $adress) AND $requestUri == '/' . $article->category->path . '/' . $article->alias . '.html/amp') {
                return view('portal.articleamp', compact('article')); //wyswietl artykuł
            }
            elseif (!in_array('amp', $adress) AND $requestUri != '/' . $article->category->path . '/' . $article->alias . '.html') {
                return redirect('/' . $article->category->path.'/'.$article->alias . '.html');
            }
            elseif (!in_array('amp', $adress) AND $requestUri == '/' . $article->category->path . '/' . $article->alias . '.html') {
                Helper::hits($article);
                // $propozycje = Content::with('User')->with('category')->where('catid', $article->catid)->where('id', '!=', $article->id)->published()->orderByDesc('publish_up')->take(10)->get();;
                $metadescription = Helper::metadescription($article);
                return view('portal.article', compact('article', 'metadescription')); //wyswietl artykuł
            }
        } elseif ($category) {
            if (in_array("amp", $adress) AND  $requestUri != '/' . $category->path . '.html/amp') {
                return redirect('/' . $category->path . '.html/amp');
            }
            elseif (in_array("amp", $adress) AND  $requestUri == '/' . $category->path . '.html/amp') {
                $categories = Category::select('id')->where('parent_id', $category->id)->orWhere('id', $category->id)->get()->pluck('id')->toArray();
                $articles = Content::whereIN('catid', $categories)->orWhereIn('id', $category->contents->pluck('id'))->published()->with('User')->with('category')->latest()->paginate(13); //pobierz artykuły z danej kategorii i podkategorii
                return view('portal.categoryamp', compact('articles', 'category'));
            }
            elseif (!in_array('amp', $adress) AND $requestUri != '/' . $category->path . '.html') {
                return redirect('/' . $category->path . '.html');
            }
            elseif (!in_array("amp", $adress) AND  $requestUri == '/' . $category->path . '.html') {
                $categories = Category::select('id')->where('parent_id', $category->id)->orWhere('id', $category->id)->get()->pluck('id')->toArray();
                $articles = Content::whereIN('catid', $categories)->orWhereIn('id', $category->contents->pluck('id'))->published()->with('User')->with('category')->latest()->paginate(13); //pobierz artykuły z danej kategorii i podkategorii
                return view('portal.category', compact('articles', 'category'));
            }
        }
         else {
            return redirect('/');
        }
    }
    public function glosuj(Request $request)
    {
        $poll = Polls::findOrFail($request->input('poll'));
        $votes = json_decode($poll->polls, true);
        $votes['votes_'.$request->input('vote')] = $votes['votes_' . $request->input('vote')]+1;
        $votes = json_encode($votes);
        setcookie($request->input('poll'), $request->input('vote'));
        $poll->update(['polls' => $votes]);
        return redirect('/');
    }

    public function findimagefromtext($od, $do)
    {
        $content = Content::whereBetween('id', [$od, $do])->get();
        foreach ($content as $key => $art) {
            $zdjglowne = Image::where('content_id', $art->id)->latest()->get();
            foreach($zdjglowne as $grafika){
                    $main_grafika = str_replace(" ", "_", $grafika->path);
                    $main_grafika = str_replace("%20", "_", $main_grafika);
                    $main_grafika = str_replace("%C3%B3", "o", $main_grafika);
                    $main_grafika = str_replace("ą", "a", $main_grafika);
                    $main_grafika = str_replace("ć", "c", $main_grafika);
                    $main_grafika = str_replace("ę", "e", $main_grafika);
                    $main_grafika = str_replace("ł", "l", $main_grafika);
                    $main_grafika = str_replace("ń", "n", $main_grafika);
                    $main_grafika = str_replace("ó", "o", $main_grafika);
                    $main_grafika = str_replace("ś", "s", $main_grafika);
                    $main_grafika = str_replace("ź", "z", $main_grafika);
                    $main_grafika = str_replace("ż", "z", $main_grafika);
                    $main_grafika = str_replace("images", "images_new/main", $main_grafika);
                    $orginalImagePath = str_replace('images_new/main', 'images_new/original', $main_grafika);

                    $oldPath = str_replace("%20", " ", $grafika->path);
                    $oldPath = str_replace("%C3%B3", "ó", $oldPath);

                    $mainname = $main_grafika;
                    // dd($orginalImagePath);
                    $path = explode("/", $main_grafika);
                    $path_for_miniaturki = 'storage/images_new/thumbs/m_' . end($path);
                    $path_for_main = 'storage/images_new/main/' . end($path);
                    $new_path = '';

                    $pathOrg = explode("/", $orginalImagePath);
                    $pathOrgCount = count($path);
                    for ($i = 0; $i < $pathOrgCount-1; $i++){
                        $new_path .= $pathOrg[$i].'/';
                    }
                    $ile = ImageNew::where('content_id', $art->id)->count();
                    // dd();
                    if ($ile < 3 and (File::exists($oldPath) or File::exists($grafika->path))) {
                        $originalWidth = 1280;
                        $originalHight = 720;

                        $mainWidth = 800;
                        $mainHeight = 450;

                        $thumbWidth = 320;
                        $thumbHeight = 180;

                        if(!File::exists($new_path)){
                            File::makeDirectory($new_path, 0777, true, true);
                        }

                        File::copy($oldPath, $orginalImagePath);
                        //original image create
                        $image_resize = ImageManager::make($orginalImagePath);
                        $image_resize->resize($originalWidth, $originalHight);
                        $image_resize->save($orginalImagePath, 70);
                        // original webp image create
                        $originalnamewebp = str_replace(".jpg", ".webp", $orginalImagePath);
                        $originalnamewebp = str_replace(".png", ".webp", $originalnamewebp);
                        ImageManager::make($orginalImagePath)->encode('webp', 75)->save($originalnamewebp);
                        //main image create
                        $image_resize = ImageManager::make($orginalImagePath);
                        $image_resize->resize($mainWidth, $mainHeight);
                        $image_resize->save($path_for_main, 70);
                        // main webp image create
                        $mainnamewebp = str_replace(".jpg", ".webp", $path_for_main);
                        $mainnamewebp = str_replace(".png", ".webp", $mainnamewebp);
                        ImageManager::make($path_for_main)->encode('webp', 75)->save($mainnamewebp);
                        //Thumbnail create
                        $image_resize_thumb = ImageManager::make($orginalImagePath);
                        $image_resize_thumb->resize($thumbWidth, $thumbHeight);
                        $image_resize_thumb->save($path_for_miniaturki);
                        // Webp Thumbnail create
                        $webp_thumb_path = str_replace(".jpg", ".webp", $path_for_miniaturki);
                        $webp_thumb_path = str_replace(".png", ".webp", $webp_thumb_path);
                        ImageManager::make($path_for_miniaturki)->encode('webp', 75)->save($webp_thumb_path);

                        ImageNew::create([
                            'content_id' => $art->id,
                            'type' => 'original',
                            'path' => $orginalImagePath,
                            'webp_path' => $originalnamewebp,
                            'alt' => $grafika->alt,
                        ]);
                        ImageNew::create([
                            'content_id' => $art->id,
                            'type' => 'main',
                            'path' => $path_for_main,
                            'webp_path' => $mainnamewebp,
                            'alt' => $grafika->alt,
                        ]);
                        ImageNew::create([
                            'content_id' => $art->id,
                            'type' => 'thumbnail',
                            'path' => $path_for_miniaturki,
                            'webp_path' => $webp_thumb_path,
                            'alt' => $grafika->alt,
                        ]);
                    }else{
                        continue;
                    }
                    /* PHOTO */
                    // $path = 'storage/images/' . date('Y') . '/' . date('m') . '/' . date('d') . '/';
                    // if ($request->hasFile('image_intro')) {
                    //     $image = $request->file('image_intro');
                    //     // dd($path);
                    //     // dd($image->getClientOriginalName());
                    //     if (!File::exists($path.'desktop/')) {
                    //         File::makeDirectory($path . 'desktop/', 0777, true, true);
                    //     }
                    //     if (!File::exists($path.'tablet/')) {
                    //         File::makeDirectory($path . 'tablet/', 0777, true, true);
                    //     }
                    //     if (!File::exists($path.'mobile/')) {
                    //         File::makeDirectory($path . 'mobile/', 0777, true, true);
                    //     }
                    //     $desktopWidth = 960;
                    //     $desktopHeight = 540;

                    //     $tabletWidth = 640;
                    //     $tabletHeight = 360;

                    //     $mobileWidth = 480;
                    //     $mobileHeight = 270;

                    //     $fileDesktop = $desktopWidth.'x'.$desktopHeight.'.';
                    //     $fileTablet = $tabletWidth.'x'.$tabletHeight.'.';
                    //     $fileMobile = $mobileWidth.'x'.$mobileHeight.'.';

                    //     $filenameDesktop    = str_replace('.', $fileDesktop, $image->getClientOriginalName());
                    //     $filenameTablet   = str_replace('.', $fileTablet, $image->getClientOriginalName());
                    //     $filenameMobile    = str_replace('.', $fileMobile, $image->getClientOriginalName());

                    //     $image_resize = Image::make($image->getRealPath());

                    //     $image_resize->resize($desktopWidth, $desktopHeight);
                    //     $image_resize->save($path.'desktop/'. $filenameDesktop);
                    //     $imagedesktop = $path.'desktop/'. $filenameDesktop;

                    //     $image_resize->resize($tabletWidth, $tabletHeight);
                    //     $image_resize->save($path.'tablet/' . $filenameTablet);
                    //     $imagetablet = $path.'tablet/' . $filenameTablet;

                    //     $image_resize->resize($mobileWidth, $mobileHeight);
                    //     $image_resize->save($path.'mobile/' . $filenameMobile);
                    //     $imagemobile = $path.'mobile/' . $filenameMobile;
                    // }
                    // $oldname = str_replace("storage/images", "/public/images", $grafika->path);
                    // dd(str_replace("storage/images", "public/images", $oldname));
                    // dd(File::exists($grafika->path));
                }
            // $str = $art->fulltext;
            // preg_match_all($re, $str, $matches, PREG_SET_ORDER, 0);
            // if (count($matches) > 0) {
            //         $nowa_grafika = str_replace(" ", "_", $matches[0][1]);
            //         $nowa_grafika = str_replace("ą", "a", $nowa_grafika);
            //         $nowa_grafika = str_replace("ć", "c", $nowa_grafika);
            //         $nowa_grafika = str_replace("ę", "e", $nowa_grafika);
            //         $nowa_grafika = str_replace("ł", "l", $nowa_grafika);
            //         $nowa_grafika = str_replace("ń", "n", $nowa_grafika);
            //         $nowa_grafika = str_replace("ó", "o", $nowa_grafika);
            //         $nowa_grafika = str_replace("ś", "s", $nowa_grafika);
            //         $nowa_grafika = str_replace("ź", "z", $nowa_grafika);
            //         $nowa_grafika = str_replace("ż", "z", $nowa_grafika);

            //         $result = preg_replace($re, $nowa_grafika, $str);
            //         dd($str,$result);
            // }
            // else{
            //     continue;
            // }
        }
        return 'succes artykuły' . $od . 'do' . $do;
    }
    public function getProposition($catid, $id){
        $propozycje = Content::with('User')->with('category')->where('catid', $catid)->where('id', '!=', $id)->published()->orderByDesc('publish_up')->take(4)->get();
        $returnHTML = view('portal.propozycje', compact('propozycje'))->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }
}
