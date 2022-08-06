<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuLink extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'id',
        'category_id',
        'menu_id',
        'published',
        'parent_id',
        'level',
        'position',
    ];

    /* Relationships */

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
