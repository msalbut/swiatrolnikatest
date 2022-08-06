<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Content;
use Illuminate\Http\Request;

class RssController extends Controller
{
    public function feed($kategoria, $podkategoria = null)
    {
        $path = (is_null($podkategoria) ? $kategoria : $kategoria.'/'.$podkategoria);
        $category = Category::where('path', $path)->first();
        $categories = [$category->id] + Category::where('parent_id', $category->id)->get()->pluck('id')->toArray();

        $articles = Content::published()->whereIn('catid', $categories)->orderBy('publish_up', 'desc')->take(40)->get();
        $nazwakategorii = $category->title;
        $pathcategory = $category->path;

        return response()->view('rss.category', compact('articles', 'nazwakategorii', 'pathcategory'))->header('Content-Type', 'application/xml');
    }

    public function najnowszefeed()
    {
        $articles = Content::published()->orderBy('publish_up', 'desc')->take(100)->get();

        return response()->view('rss.najnowsze', compact('articles'))->header('Content-Type', 'application/xml');
    }
}
