<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Content;
use App\Models\Menu;
use App\Models\Polls;
use App\Models\User;
use App\Models\UserGroup;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $count['article'] = Content::where('state', '>=', '0')->count();
        $count['category'] = Category::where('published', '>', '0')->count();
        $count['user'] = User::count();
        $count['usergroups'] = UserGroup::count();
        // $count['menu'] = Menu::count();
        $count['polls'] = Polls::count();
        View::share('count', $count);
        Paginator::useBootstrap();
    }
}
