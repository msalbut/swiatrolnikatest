<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $with = ['permission'];

    public function user()
    {
        return $this->hasMany(User::class, 'user_group_id', 'id');
    }
    public function permission()
    {
        return $this->belongsToMany(Permission::class, 'group_permission', 'user_group_id', 'permission_id');
    }
    public function permissionForRoute()
    {
        return $this->belongsToMany(Permission::class, 'group_permission', 'user_group_id', 'permission_id')->where('type', 'route');
    }
    public function accessTo()
    {
        return $this->belongsToMany(Permission::class, 'group_permission', 'user_group_id', 'permission_id')->where('type', 'other');
    }
}
