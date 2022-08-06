<?php

namespace App\View\Components\Portal;

use Illuminate\View\Component;
use App\Models\Content;
use App\Models\Category;


class RightBox extends Component
{

    public $artykuly;
    public $category;
    public $categories;

    public function __construct($catid, $id)
    {
        $this->category = Category::where('id', $catid)->where('published', 1)->orderByDesc('level')->first();
        $this->categories = Category::select('id')->where('parent_id', $this->category->id)->orWhere('id', $this->category->id)->get()->pluck('id')->toArray();
        //
        $this->artykuly = Content::whereIn('catid', $this->categories)
        ->where('id', '!=' ,$id)
        ->published()
        ->with('User')
        ->with('category')
        ->orderBy('publish_up', 'desc')
        ->take(100)
        ->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.portal.right-box');
    }
}
