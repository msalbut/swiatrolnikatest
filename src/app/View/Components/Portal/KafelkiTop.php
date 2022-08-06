<?php

namespace App\View\Components\portal;

use Illuminate\View\Component;
use App\Models\Content;

class KafelkiTop extends Component
{
    public $artykuly, $artwithposition, $arts;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->artwithposition = Content::with('User')->with('category')->published()->whereNotIn('id', $GLOBALS['id_art'])->where('has_position', 'yes')->orderBy('publish_up', 'desc')->take(8)->get()->keyBy('position');
        $array = array_merge($GLOBALS['id_art'], $GLOBALS['id_art'], $this->artwithposition->pluck('id')->toArray());
        // dd($array);
        $this->artykuly = Content::with('User')->with('category')->published()->whereNotIn('id', $array)->orderBy('publish_up', 'desc')->take(16)->get();
        $artykuly = range(1, 16);
        foreach ($artykuly as $key => $index) {
            if (isset($this->artwithposition[$index])) {
                $artykuly[$key] = $this->artwithposition[$index];
            } else {
                $artykuly[$key] = $this->artykuly->shift();
            }
        }
        $this->arts = $artykuly;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.portal.kafelki-top');
    }
}
