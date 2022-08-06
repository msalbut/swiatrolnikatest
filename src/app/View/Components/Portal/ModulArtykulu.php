<?php

namespace App\View\Components\Portal;

use Illuminate\View\Component;
use App\Models\Content;
use App\Models\Category;

class ModulArtykulu extends Component
{
    public $artykuly;
    public $nazwa;
    public $category;
    public $categories;
    public $icon;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $nazwa, $icon)
    {
        $this->nazwa = $nazwa;
        $this->icon = $icon;

        $this->category = Category::where('id', $id)->where('published', 1)->orderByDesc('level')->first();
        $this->categories = Category::select('id')->where('parent_id', $this->category->id)->orWhere('id', $this->category->id)->get()->pluck('id')->toArray();
        $this->artykuly = Content::whereIn('catid', $this->categories)
        ->whereNotIn('id', $GLOBALS['id_art'])
        ->whereNotIn('id', $GLOBALS['id_art_kafelki'])
        ->published()->with('User')->with('category')->orderBy('publish_up', 'desc')->take(14)->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.portal.modul-artykulu');
    }
}
