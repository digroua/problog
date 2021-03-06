<?php

namespace App\Providers;

use App\Post;
use App\Comment;
use App\Category;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        view()->composer('pages._sidebar', function($view){
           $view->with('popularPosts', Post::getPopularPosts());
           $view->with('featuredPosts', Post::where('is_featured', 1)->take(3)->pluck('id')->all());
           $view->with('recentPosts', Post::orderBy('date', 'desc')->take(4)->get());
           $view->with('categories', Category::all());
        });

        view()->composer('admin._sidebar', function($view){
            $view->with('newCommentsCount', Comment::where('status', 0)->count());

        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
