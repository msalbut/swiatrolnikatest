<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImageNew extends Model
{
    protected $table = 'images_new';

    protected $fillable = [
        'id',
        'content_id',
        'type',
        'alt',
        'path',
        'webp_path',
    ];

    public function article()
    {
        return $this->belongsTo(Content::class);
    }
}
