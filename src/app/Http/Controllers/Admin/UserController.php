<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
// use App\Models\UserGroup_map;
use Illuminate\Http\Request;
use App\Classes\Helper;
use App\Models\UserGroup;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(){
        $title = "Użytkownicy";
        // with('usergroup')->where('id', 478)
        // $users = UserGroup::first();
        // CheckAccessForUser('administrator.category.index')
        dump(Auth::user()->CheckAccessForUser('administrator.dashboard'));
        dd(1);
        return view('admin.users.uzytkownicy', compact('users', 'title'));
    }
    public function edit(){
        $title = "Edycja Użytkownika";
        return view('admin.users.edit', compact('title'));
    }
    public function create(){
        $title = "Tworzenie nowego użytkownika";
        return view('admin.users.create', compact('title'));
    }
    public function change(Request $request, $id){
        $user = User::findOrFail($id);

        if ($request->has('action')) {
            $action = $request->get('action');
            switch ($action) {
                case 'ban':
                    $user->fill(['block' => 1]);
                    Helper::makerevision($user);
                    $user->save();
                    return back()->with(['message' => 'Użytkownik został zablokowany.', 'type' => 'danger']);
                    break;
                case 'unban':
                    $user->fill(['block' => 0]);
                    Helper::makerevision($user);
                    $user->save();
                    return back()->with(['message' => 'Użytkownik został odblokowany.', 'type' => 'success']);
                    break;
                case 'active':
                    $user->fill(['activ' => 1]);
                    Helper::makerevision($user);
                    $user->save();
                    return back()->with(['message' => 'Logowanie dla użytkownika zostało włączone.', 'type' => 'success']);
                    break;
                case 'unactive':
                    $user->fill(['activ' => 0]);
                    Helper::makerevision($user);
                    $user->save();
                    return back()->with(['message' => 'Logowanie dla użytkownika zostało wyłączone.', 'type' => 'danger']);
                    break;
                default:
                    return back()->with(['message' => 'Nieznane polecenie.', 'type' => 'warning']);
            }
        }
    }
}
