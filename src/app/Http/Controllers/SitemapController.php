<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Models\Content;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd($kategoria, $podkategoria);
        $categories = Category::where('level','>',0)->where('parent_id', '>' ,0)->latest()->get();
        //dd($categorys);
        $today = date("Y-m-d H:i:s");
        $articles = Content::where('publish_up','<',$today)->where('state', 1)->with('category')->orderByDesc('publish_up')->get();
        // dd($articles->category->path);


        return response()->view('sitemap.index', compact('articles', 'categories'))->header('Content-Type', 'application/xml');
        // return response()->view('rss.category', compact('articles', 'nazwakategorii', 'pathcategory'))->header('Content-Type', 'application/xml');


    }
    public function news()
    {

        $today = date("Y-m-d H:i:s");
        $od = date('Y-m-d H:i:s', strtotime('-2 days'));
        $articles = Content::where('publish_up','<',$today)->where('publish_up','>', $od)->where('state', 1)->with('category')->orderByDesc('publish_up')->get();
        // dd($articles->category->path);


        return response()->view('sitemap.news', compact('articles'))->header('Content-Type', 'application/xml');
        // return response()->view('rss.category', compact('articles', 'nazwakategorii', 'pathcategory'))->header('Content-Type', 'application/xml');


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
