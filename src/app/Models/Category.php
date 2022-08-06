<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $with = ['contents'];
    protected $fillable = [
        'id',
        'parent_id',
        'level',
        'path',
        'title',
        'alias',
        'description',
        'published',
        'position',
        'version',
        'created_user_id',
        'modified_user_id',
        'created_at',
        'updated_at',
    ];
    public function articles()
    {
        return $this->belongsTo(Content::class);
    }
    public function contents()
    {
        return $this->belongsToMany(Content::class, 'category_content', 'category_id', 'content_id');
    }
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }
}
