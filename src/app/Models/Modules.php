<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modules extends Model
{
    protected $table = 'modules';
    protected $fillable = [
        'id',
        'name',
        'view',
        'position',
        'icon',
        'asset_id',
        'created_id',
        'modifier_id',
    ];
}
