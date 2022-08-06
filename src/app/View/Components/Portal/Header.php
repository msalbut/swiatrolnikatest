<?php

namespace App\View\Components\Portal;

use Illuminate\View\Component;

class Header extends Component
{
    public $type;
    public $mode;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type, $mode)
    {
        $this->type=$type;
        $this->mode=$mode;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.portal.header');
    }
}
