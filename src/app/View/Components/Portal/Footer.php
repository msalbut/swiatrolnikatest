<?php

namespace App\View\Components\Portal;

use Illuminate\View\Component;
use App\Models\Content;

class Footer extends Component
{
    public $type;
    public $mode, $week;
    public $toparticle;

    public function __construct($type, $mode)
    {
        $this->type=$type;
        $this->mode=$mode;
        $this->week = date("Y-m-d H:i:s", strtotime('-7 day', strtotime('Y-m-d H:i:s')));
        $this->toparticle = Content::with('User')->with('category')->published()->where('publish_up', '>', $this->week)->orderBy('hits', 'desc')->take(10)->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.portal.footer');
    }
}
