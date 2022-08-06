<?php

namespace App\View\Components\Portal;

use Illuminate\View\Component;
use App\Models\Content;

class Top10 extends Component
{
    protected $today;
    protected $mounth;
    public $toparticle;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->today = date("Y-m-d H:i:s");
        $this->mounth = date("Y-m-d H:i:s", strtotime('-7 day', strtotime($this->today)));
        $this->toparticle = Content::with('User')->with('category')->where('publish_up', '<', $this->today)->where('state',  1)->where('publish_up', '>', $this->mounth)->orderBy('hits', 'desc')->take(10)->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.portal.top10');
    }
}
