<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Content;
use Auth;
use Illuminate\Routing\RouteGroup;
use App\Classes\Helper;
use function PHPSTORM_META\type;

class CategoryController extends Controller
{
    public function index()
    {
        $title = "Kategorie";
        $categories = Category::whereIN('level', [1, 2])->get();
        $hiddencats = Category::where('level', 0)->get();
        $content = $categories->groupBy('level');
        $main_category = $content[1]->sortBy('position');
        $secoundary_category = $content[2]->groupBy('parent_id');
        $ilosc_art = array();
        foreach ($categories as $category) {
            $art_published = Content::where('state', 1)->where('catid', $category->id)->count();
            $art_unpublished = Content::where('state', 0)->where('catid', $category->id)->count();
            $art_archive = Content::where('state', 2)->where('catid', $category->id)->count();
            $art_trash = Content::where('state', -2)->where('catid', $category->id)->count();

            $ilosc_art += array(
                $category->id => [
                    'published' => $art_published,
                    'unpublished' => $art_unpublished,
                    'archive' => $art_archive,
                    'trash' => $art_trash,
                ]
            );
        }
        $hidden_art = array();
        // dd($hiddencats);
        foreach ($hiddencats as $categorys) {
            $art_published = Content::where('state', 1)->where('catid', $categorys->id)->count();
            $art_unpublished = Content::where('state', 0)->where('catid', $categorys->id)->count();
            $art_archive = Content::where('state', 2)->where('catid', $categorys->id)->count();
            $art_trash = Content::where('state', -2)->where('catid', $categorys->id)->count();

            $hidden_art += array(
                $categorys->id => [
                    'published' => $art_published,
                    'unpublished' => $art_unpublished,
                    'archive' => $art_archive,
                    'trash' => $art_trash,
                ]
            );
        }

        return view('admin.category.categories', compact('title', 'main_category', 'secoundary_category', 'ilosc_art', 'hiddencats', 'hidden_art'));
    }
    public function change(Request $request, $id){
        $category = Category::findOrFail($id);
        if ($request->has('action')) {
            $action = $request->get('action');
            switch ($action) {
                case 'unpublish':
                    if ($category->level == 1) {
                        $category_childs = Category::where('parent_id', $category->id)->get();
                        foreach ($category_childs as $key => $category_child) {
                            $category_child->fill(['published' => 0]);
                            Helper::makerevision($category_child);
                            $category_child->save();
                        }
                        $return = redirect()->back()->with(['message' => 'Kategoria, wraz z podkategoriami wycofana z publikacji.', 'type' => 'danger']);
                    }
                    else{
                        $return = redirect()->back()->with(['message' => 'Kategoria wycofana z publikacji.', 'type' => 'danger']);
                    }
                    $category->fill(['published' => 0]);
                    Helper::makerevision($category);
                    $category->save();
                    break;
                case 'publish':
                    $category->fill(['published' => 1]);
                    Helper::makerevision($category);
                    $category->save();
                    $return = redirect()->back()->with(['message' => 'Kategoria została opublikowana.', 'type' => 'success']);
                    break;
                case 'archive':
                    if ($category->level == 1) {
                        $category_childs = Category::where('parent_id', $category->id)->get();
                        foreach ($category_childs as $key => $category_child) {
                            $category_child->fill(['published' => 2]);
                            Helper::makerevision($category_child);
                            $category_child->save();
                        }
                        $return = redirect()->back()->with(['message' => 'Kategoria, wraz z podkategoriami została zarchiwizowana.', 'type' => 'info']);
                    }
                    $category->fill(['published' => 2]);
                    Helper::makerevision($category);
                    $category->save();
                    $return = redirect()->back()->with(['message' => 'Kategoria została zarchiwizowana.', 'type' => 'info']);
                    break;
                case 'delete':
                    if ($category->level == 1) {
                        $category_childs = Category::where('parent_id', $category->id)->get();
                        foreach ($category_childs as $key => $category_child) {
                            $category_child->fill(['published' => -2]);
                            Helper::makerevision($category_child);
                            $category_child->save();
                        }
                        $return = redirect()->back()->with(['message' => 'Kategoria, wraz z podkategoriami została przeniesiona do kosza.', 'type' => 'dark']);
                    }
                    $category->fill(['published' => -2]);
                    Helper::makerevision($category);
                    $category->save();
                    $return = redirect()->back()->with(['message' => 'Kategoria została przeniesiona do kosza.', 'type' => 'dark']);
                    break;
                default:
                    $return = redirect()->back()->with(['message' => 'Nieznana operacja.', 'type' => 'warning']);
            }
            return $return;
        }
        return redirect()->back();
    }
    public function edit($id){
        $title = "Edycja Kategorii";
        $category = Category::findOrFail($id);
        $categories = Category::where('published', 1)->whereIN('level', [1, 0])->orderBy('position')->get();
        return view('admin.category.edit', compact('title', 'category', 'categories'));
    }
    public function update(Request $request, $id)
    {
        $form = $request->all();
        if ($form['btn'] != 'zamknij') {
            $request->validate([
                'title' => 'required|max:255',
                'description' => 'required|max:300',
            ]);
        }
        $form['alias'] = \Str::slug($request->input('title'));
        $category = Category::findOrFail($id);
        $parent_category = Category::findOrFail($form['parent_id']);
        $form['position'] = $parent_category->position;
        $form['level'] = ++$parent_category->level;
        $form['version'] = ++$category->version;
        switch ($form['btn']) {
            case 'zapisz':
                $category->fill($form);
                Helper::makerevision($category);
                $category->save();
                return redirect()->back()->with(['message' => 'Zmiany zostały zapisane.', 'type' => 'success']);
                break;
            case 'zapisz-i-zamknij':
                $category->fill($form);
                Helper::makerevision($category);
                $category->save();
                return redirect(route('administrator.category.index'))->with(['message' => 'Zmiany zostały zapisane.', 'type' => 'success']);
                break;
            case 'zamknij':
                return redirect(route('administrator.category.index'))->with(['message' => 'Zmiany nie zostały zapisane.', 'type' => 'danger']);
                break;
            }

    }
    public function create()
    {
        $title = "Tworzenie nowej Kategorii";
        $categories = Category::where('published', 1)->whereIN('level', [1, 0])->orderBy('position')->get();
        return view('admin.category.create', compact('title', 'categories'));
    }
    public function store(Request $request)
    {
        $form = $request->all();
        if($form['btn'] != 'zamknij'){
            $request->validate([
                'title' => 'required|unique:categories|max:255',
                'description' => 'required|max:300',
            ]);
        }
        $form['position'] = 1;
        $form['alias'] = \Str::slug($request->input('title'));
        if ($form['parent_id'] == 1) {
            $form['path'] = $form['alias'];
            $form['level'] = 1;
        } else{
            $path = Category::select('path', 'position', 'level')->where('id', $form['parent_id'])->first();
            $form['path'] = $path->path.'/'.$form['alias'];
            $form['position'] = $path->position;
            $form['level'] = ++$path->level;

        }
        $form['version'] = 1;
        $form['created_user_id'] = Auth::user()->id;
        switch ($form['btn']) {
            case 'zapisz':
                Category::create($form);
                return redirect()->back()->with(['message' => 'Kategoria została utworzona.', 'type' => 'success']);
                break;
            case 'zapisz-i-zamknij':
                Category::create($form);
                return redirect(route('administrator.category.index'))->with(['message' => 'Kategoria została utworzona.', 'type' => 'success']);
                break;
            case 'zamknij':
                return redirect(route('administrator.category.index'))->with(['message' => 'Kategoria nie została utworzona.', 'type' => 'danger']);
                break;
        }
    }
}
