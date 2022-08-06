<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    CONST ARTICLE_LABELS = [
        'material_partnera' => 'MATERIAŁ PARTNERA',
        'nasz_wywiad' => 'NASZ WYWIAD',
        'pilne' => 'PILNE',
        'tylko_u_nas' => 'TYLKO U NAS',
        'wazne' => 'WAŻNE',
    ];

    CONST ARTICLE_STATES = [
        'publish' => 1,
        'unpublish' => 0,
        'archive' => 2,
        'trash' => -2,
    ];

    const PHOTO_PATH = '/images/';
    protected $table = 'content';
    protected $with = [
        'image',
        // 'orginalImage',
        // 'mainImage',
        // 'thumbnail'
    ];

    protected $fillable = [
        'id',
        'title',
        'alias',
        'fulltext',
        'state',
        'catid',
        'created_by',
        'modified_by',
        'checked_out',
        'checked_out_time',
        'publish_up',
        'publish_down',
        'urls',
        'author_id',
        'version',
        'type',
        'alarm',
        'ordering',
        'hits',
        'featured',
        'focus_keyword',
        'etykieta',
        'has_position',
        'position',
        'image_not_required',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'author_id');
    }

    public function lastEditor()
    {
        return $this->hasOne(User::class, 'id', 'modified_by');
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'catid');
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_content', 'content_id', 'category_id');
    }
    public function image()
    {
        return $this->hasMany(Image::class);
    }

    public function imageNew()
    {
        return $this->hasMany(ImageNew::class);
    }

    public function scopePublished($query)
    {
        return $query->where('publish_up', '<', date("Y-m-d H:i:s"))->where('state', 1);
    }

    public function hasLabel()
    {
        return (bool) $this->etykieta;
    }

    public function getLabel()
    {
        return self::ARTICLE_LABELS[$this->etykieta];
    }
    public function blocked()
    {
        return $this->hasMany(Blocked::class);
    }
    public function isBlocked()
    {
        return Blocked::where('state', 1)->where('content_id', $this->id)->first();
    }

    //Zdjęcia nowe
    public function orginalImage()
    {
        return $this->hasOne(ImageNew::class)->where('type', 'original');
    }
    public function mainImage()
    {
        return $this->hasOne(ImageNew::class)->where('type', 'main');
    }
    public function thumbnail()
    {
        return $this->hasOne(ImageNew::class)->where('type', 'thumbnail');
    }

}
