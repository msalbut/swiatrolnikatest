<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';

    protected $fillable = [
        'id',
        'content_id',
        'type',
        'alt',
        'path',
    ];

    public function article()
    {
        return $this->belongsTo(Content::class);
    }
}
