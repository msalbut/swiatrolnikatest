<?php

namespace App\View\Components\Portal;

use Illuminate\View\Component;
use App\Models\Polls;

class Sonda extends Component
{
    public $poll;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->poll = Polls::where('published', 1)->latest()->first();
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.portal.sonda');
    }
}
