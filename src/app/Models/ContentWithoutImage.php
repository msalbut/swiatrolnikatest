<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentWithoutImage extends Model
{
    protected $table = 'content_without_image';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'content_id',
    ];
}
