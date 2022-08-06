<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Category;
use App\Models\Configuration;

class ConfigController extends Controller
{
    public function menu()
    {
        $menutype = Menu::select('menutype')->distinct()->get();
        $config = Configuration::where('type', 'menu')->first();
        return view('admin.configuration.menu.index', compact('menutype', 'config'));
    }
    public function menuChange(Request $request, $id)
    {
        $form = $request->all();
        Configuration::findOrFail($id)->update($form);
        return redirect()->back()->with(['message' => 'Menu zostało zmienione', 'type' => 'success']);
    }
    public function module()
    {
        $categories = Category::where('published', 1)->where('level', '>', 0)->where('parent_id', '>', 0)->get();
        $cat = $categories->groupBy('level');
        $main_category = $cat[1]->sortBy('position');
        $secoundary_category = $cat[2]->groupBy('parent_id');
        $config = Configuration::where('type', 'module')->where('published', '1')->orderBy('position')->get();

        return view('admin.configuration.module.index', compact('main_category', 'secoundary_category','config'));
    }
    public function moduleEdit(Request $request, $id)
    {
        $form = $request->all();
        // dd($form);
        Configuration::findOrFail($id)->update($form);
        return redirect()->back()->with(['message' => 'Moduł został zaktualizowany', 'type' => 'success']);
    }
    public function moduleDelete($id)
    {
        Configuration::findOrFail($id)->update(['published' => '0']);
        return redirect()->back()->with(['message' => 'Menu zostało zmienione', 'type' => 'success']);
    }
}
