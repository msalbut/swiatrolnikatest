<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Polls extends Model
{
    protected $table = 'polls';
    protected $fillable = [
        'title',
        'alias',
        'polls',
        'published',
        'created_by',
        'modified_by'
    ];
    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function lastEditor()
    {
        return $this->hasOne(User::class, 'id', 'modified_by');
    }
}
