<?php

namespace App\View\Components\portal;

use Illuminate\View\Component;
use App\Models\Content;

class News extends Component
{
    protected $today;
    public $artykulnews;
    public $artykuly;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->today = date("Y-m-d H:i:s");
        $this->artykulnews = Content::with('User')->with('category')->published()->where('featured', 1)->orderBy('publish_up', 'desc')->latest()->first();
        $this->artykuly = Content::with('User')->with('category')->published()->where('has_position', 'no')->whereNotIn('id', [$this->artykulnews->id])->orderBy('publish_up', 'desc')->take(7)->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.portal.news');
    }
}
