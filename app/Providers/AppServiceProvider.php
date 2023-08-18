<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use App\Models\Setting;
use App\Models\Category;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        Schema::defaultStringLength(191);

        $settings = Setting::find(1);
        $categories = Category::where('parent_id', null)->orderBy('order', 'asc')->get();

        View::share('settings', $settings);

        View::share('categories', $categories);
    }
}
