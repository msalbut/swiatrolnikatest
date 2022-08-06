<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blocked extends Model
{
    protected $table = 'blocked_article';
    public $timestamps = false;
    protected $with = ['user'];
    protected $fillable = [
        'id',
        'user_id',
        'content_id',
        'state',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
