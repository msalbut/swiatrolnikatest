<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    public $timestamps = false;
    protected $table = 'configuration';
    protected $fillable = [
        'id',
        'category_id',
        'type',
        'name',
        'icon',
        'position',
        'class',
        'published',
    ];
}
