<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserGroup;
use App\Models\Permission;
use Illuminate\Http\Request;


class UserGroupsController extends Controller
{
    public function index()
    {
        $title = "Grupy użytkowników";
        // $groups = UserGroup::withCount('user')->get();
        $groups = UserGroup::withCount('user')->get();
        return view('admin.usersgroups.grupyuzytkownikow', compact('groups', 'title'));
    }
    public function edit($id)
    {
        $title = "Edycja grupy użytkowników";
        // $groups = UserGroup::withCount('user')->get();
        $group = UserGroup::findOrFail($id);
        $group_permission = $group->permission->pluck('id')->toArray();
        $permissions = Permission::get();
        return view('admin.usersgroups.edit', compact('permissions', 'group', 'group_permission', 'title'));
    }
    public function update(Request $request, $id)
    {
        $form = $request->all();
        $group = UserGroup::findOrFail($id);
        $group->permission()->detach();
        if($request->permissions){
            foreach($request->permissions as $permission){
                $group->permission()->attach([
                    'permission_id' => $permission,
                ]);
            }
        }
        return back();
    }
    public function create(){
        $title = "Tworzenie grupy użytkowników";
        return view('admin.usersgroups.create', compact('title'));
    }
    public function store(Request $request){

    }
}
