<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MenuLink;
use App\Models\Menu;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::all();
        $structures = array();
        foreach ($menus as $menu){
            $structures[$menu->name] = Menu::getStructureByMenuName($menu->name);
        }
        // $menus = Menu::with('links.category')->get();
        // dd($structures);

        return view('admin.menu.index', compact('structures'));
    }

    public function create()
    {
        return view('admin.menu.create');
    }

    public function store(Request $request)
    {
        // dd($request->input('name'));
        Menu::create($request->all());
        return redirect()->back()->with(['message' => 'Menu zostało utworzone', 'type' => 'success']);

    }
    public function createposition($name)
    {
        $menu = Menu::where('name', $name)->first();
        $categories = Category::where('published', 1)->where('level', '>', 0)->where('parent_id', '>', 0)->get();
        $cat = $categories->groupBy('level');
        $main_category = $cat[1]->sortBy('position');
        $secoundary_category = $cat[2]->groupBy('parent_id');

        return view('admin.menu.create_position', compact('menu', 'main_category', 'secoundary_category'));
    }

    public function storeposiposition(Request $request)
    {
        dd($request->input('name'));
        // Menu::create($request->all());
        return redirect()->back()->with(['message' => 'Menu zostało utworzone', 'type' => 'success']);

    }

    public function edit(MenuLink $menuLink)
    {
        return view('admin.menu.edit', compact('menuLink'));
    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}
