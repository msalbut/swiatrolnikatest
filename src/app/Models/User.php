<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    protected $with = ['usergroup.permission', 'userinfo'];
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'block',
        'sendEmail',
        'lastvisitDate',
        'activ',
        'requireReset',
        'usergroup_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function usergroup()
    {
        return $this->hasOne(UserGroup::class, 'id', 'user_group_id');
    }

    public function userinfo()
    {
        return $this->hasOne(UserInfo::class, 'user_id', 'id');
    }

    public function isUser()
    {
        return $this->usergroup->name == "uzytkownik";
    }
    public function isBaned()
    {
        return $this->block == 1;
    }
    public function userGroupName()
    {
        return UserGroup::where('id', $this->user_group_id)->first()->title;
    }
    public function CheckAccessForUser($route_name)
    {
        foreach ($this->usergroup->permissionForRoute as $key => $permission) {
            $check = str_contains($route_name, $permission->access);
            if($permission->access == $route_name OR $check) {
                return true;
            }
        }
        return false;
    }
    public function CheckAccessForAccesTo($acces_name){
        foreach ($this->usergroup->accessTo as $key => $accessTo) {
            if ($accessTo->access == $acces_name) {
                return true;
            }
        }
    }
}
