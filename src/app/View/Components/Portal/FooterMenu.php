<?php

namespace App\View\Components\Portal;

use App\Models\Menu as MenuModel;
use App\Models\Configuration;
use Illuminate\View\Component;

class FooterMenu extends Component
{
    public $menu;
    /**
     * Create a new component instance.
     *
     * @return void
     */
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
        return view('components.portal.footer-menu');
    }
}
