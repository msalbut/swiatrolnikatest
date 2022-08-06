<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Content;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $title = "Kokpit";
        $users = User::orderByDesc('lastvisitDate')->take(5)->get();
        return view('admin.panel', compact('title', 'users'));
    }
}
