<?php

namespace App\View\Components\portal;

use Illuminate\View\Component;
use App\Models\Content;

class Alarm extends Component
{
    public $artykul;
    public function __construct()
    {
        $this->artykul = Content::with('User')->with('category')->where('alarm',1)->published()->orderBy('publish_up', 'desc')->first();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.portal.alarm');
    }
}
