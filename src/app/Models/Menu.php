<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'id',
        'name',
    ];

    /* Relationships */

    public function links()
    {
        return $this->hasMany(MenuLink::class);
    }

    /* Static methods */

    public static function getIdByName($menuName)
    {
        return Menu::where('name', $menuName)->firstOrFail()->id;
    }

    public static function getStructureByMenuName($menuName)
    {
        if (!$menuName == null) {
            $menuId = Menu::getIdByName($menuName);

            $links = MenuLink::with('category')->where('menu_id', $menuId)->whereHas('category')->where('published', 1)->get();

            $menu = $links->where('level', 1)->sortBy('position');
            $structure = $menu->map(function ($link) use ($links) {
                $link->children = $links->where('parent_id', $link->id)->where('level', 2)->sortBy('position');
                return $link;
            });

            return $structure;
        }else{
            $links = MenuLink::with('category')->with('menu')->whereHas('category')->where('published', 1)->get();

            $menu = $links->where('level', 1)->sortBy('position');
            $structure = $menu->map(function ($link) use ($links) {
                $link->children = $links->where('parent_id', $link->id)->where('level', 2)->sortBy('position');
                return $link;
            });

            return $structure;
        }
    }
}
