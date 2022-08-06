<?php

namespace App\View\Components\amp;

use Illuminate\View\Component;
use App\Models\Menu as MenuModel;
use App\Models\Configuration;

class Menu extends Component
{
    public $menu;

    public function __construct()
    {
        $config = Configuration::where('type', 'menu')->first();
        $this->menu = MenuModel::getStructureByMenuName($config->name);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.amp.menu');
    }
}
