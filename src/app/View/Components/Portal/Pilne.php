<?php

namespace App\View\Components\portal;

use Illuminate\View\Component;
use App\Models\Content;
use App\Classes\Helper;

class Pilne extends Component
{
    public $pilne;
    protected $today;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->today = date("Y-m-d H:i:s");
        $this->pilne = Content::with('category')->published()->where('type', "pilne")->latest()->first();
    }

    public function render()
    {
        return view('components.portal.pilne');
    }
}
