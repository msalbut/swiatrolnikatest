<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'photo', 'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getPhotoPath()
    {
        return public_path($this->photo);
    }
}
