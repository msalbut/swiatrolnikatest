<?php

namespace App\View\Components\Portal;

use App\Models\Menu as MenuModel;
use App\Models\Configuration;
use Illuminate\View\Component;

class Menu extends Component
{
    public $menu;

    public function __construct()
    {
        $config = Configuration::where('type', 'menu')->first();
        $this->menu = MenuModel::getStructureByMenuName($config->name);
    }

    public function render()
    {
        return view('components.portal.menu');
    }
}
