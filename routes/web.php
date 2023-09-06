<?php

use Illuminate\Support\Facades\Route;
use App\Models\Category;
use App\Models\Product;
use App\Models\MainBanner;
use App\Models\Video;
use App\Models\Page;
use App\Models\City;
use App\Models\Firm;
use App\Models\Setting;

Route::get('/', function () {
    $mainbanners = MainBanner::all();

    return view('home', compact('mainbanners'));
});

Route::get('catalog/{slug}', function ($slug) {
    $category = Category::with('children', 'products')->where('slug', $slug)->first();

    if(!$category) {
        $category = Category::with('children', 'products')->find($slug);
    }

    return view('category', compact('category'));
});

Route::get('product/{slug}', function ($slug) {
    $product = Product::where('slug', $slug)->first();

    if(!$product) {
        $product = Product::find($slug);
    }
    
    $product->view_counter = $product->view_counter + 1;
    $product->save();

    $random = Product::where('category_id', $product->category_id)->where('id', '!=', $product->id)->inRandomOrder()->limit(6)->get();

    return view('product', compact('product', 'random'));
});

Route::get('cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart');
Route::get('_cart_data', [App\Http\Controllers\CartController::class, 'cartData']);
Route::post('add-to-cart/{product}', [App\Http\Controllers\CartController::class, 'add']);
Route::get('delete-from-cart/{product}', [App\Http\Controllers\CartController::class, 'delete']);
Route::post('update-cart', [App\Http\Controllers\CartController::class, 'update']);

Route::get('policy', function () {
    return view('policy');
});

Route::get('contacts', function () {
    $page = Page::find(1);

    return view('page', compact('page'));
});

Route::get('about', function () {
    $page = Page::find(2);

    return view('page', compact('page'));
});

Route::get('partnership', function () {
    $page = Page::find(3);
    
    return view('page', compact('page'));
});

Route::get('delivery-payment', function () {
    $page = Page::find(4);
    
    return view('page', compact('page'));
});

Route::get('videos', function () {
    $videos = Video::all();

    return view('videos', compact('videos'));
});

Route::get('video/{id}', function ($id) {
    $video = Video::find($id);
    $prevVideo = Video::where('id', '<', $video->id)->orderBy('id','desc')->first();
    $nextVideo = Video::where('id', '>', $video->id)->orderBy('id')->first();

    return view('video', compact('video', 'prevVideo', 'nextVideo'));
});

Route::get('energoaudit', function () {
    $settings = Setting::find(1);
    $cities = City::all();

    return view('energoaudit', compact('settings', 'cities'));
});
Route::get('energoaudit/{city}/firms', function ($city) {
    $cities = City::all();
    $city = City::where('slug', $city)->with(['firms' => function($query) { $query->where('is_audit', true); }])->first();

    return view('energoaudit-firms', compact('city', 'cities'));
});

Route::get('arenda-aerodveri', function () {
    $cities = City::all();

    return view('arenda-aerodveri', compact('cities'));
});
Route::get('arenda-aerodveri/{city}/firms', function ($city) {
    $cities = City::all();
    $city = City::where('slug', $city)->with(['firms' => function($query) { $query->where('is_arenda', true); }])->first();

    return view('arenda-aerodveri-firms', compact('city', 'cities'));
});

Route::get('firm/{id}', function ($id) {
    $firm = Firm::find($id);

    return view('firm', compact('firm'));
});

Route::get('/sitemap.xml', function () {
    $pages = Page::all();
    $products = Product::all();
    $latestUpdatedProduct = Product::orderBy('updated_at', 'desc')->first();

    return response()->view('sitemap', [
        'products' => $products,
        'pages' => $pages,
        'latestUpdatedProduct' => $latestUpdatedProduct,
    ])->header('Content-Type', 'text/xml');
});

Route::post('_leads', [App\Http\Controllers\LeadController::class, 'store']);

Route::get('_age', [App\Http\Controllers\AgeController::class, 'index']);
Route::post('_age', [App\Http\Controllers\AgeController::class, 'store']);

// ADMIN
Route::get('admin', function () {
    return view('layouts.admin');
})->middleware(['auth']);

Route::prefix("admin")->middleware(['auth'])->group(function() {
    Route::get('{any}', function () {
        return view('layouts.admin');
    })->where('any', '.*');
});

// ADMIN PAGES
Route::get('_admin/pages', [App\Http\Controllers\Admin\PageController::class, 'index'])->middleware(['auth']);
Route::get('_admin/page/{id}', [App\Http\Controllers\Admin\PageController::class, 'page'])->middleware(['auth']);
Route::put('_admin/page/{id}/update', [App\Http\Controllers\Admin\PageController::class, 'update'])->middleware(['auth']);

// ADMIN SETTINGS
Route::get('_admin/settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->middleware(['auth']);
Route::post('_admin/settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])->middleware(['auth']);

// ADMIN SETTINGS AUDIT ARENDA
Route::post('_admin/settings-aa', [App\Http\Controllers\Admin\SettingController::class, 'updateAuditArenda'])->middleware(['auth']);

// ADMIN MAIN BANNERS
Route::get('_admin/mainbanners', [App\Http\Controllers\Admin\MainBannerController::class, 'index'])->middleware(['auth']);
Route::post('_admin/mainbanners', [App\Http\Controllers\Admin\MainBannerController::class, 'store'])->middleware(['auth']);
Route::get('_admin/mainbanner/{id}', [App\Http\Controllers\Admin\MainBannerController::class, 'mainbanner'])->middleware(['auth']);
Route::put('_admin/mainbanner/{id}/update', [App\Http\Controllers\Admin\MainBannerController::class, 'update'])->middleware(['auth']);

// ADMIN CITIES
Route::get('_admin/cities', [App\Http\Controllers\Admin\CityController::class, 'index'])->middleware(['auth']);
Route::post('_admin/cities', [App\Http\Controllers\Admin\CityController::class, 'store'])->middleware(['auth']);
Route::get('_admin/city/{id}', [App\Http\Controllers\Admin\CityController::class, 'city'])->middleware(['auth']);
Route::put('_admin/city/{id}/update', [App\Http\Controllers\Admin\CityController::class, 'update'])->middleware(['auth']);
Route::delete('_admin/city/{id}/delete', [App\Http\Controllers\Admin\CityController::class, 'delete'])->middleware(['auth']);

// ADMIN FIRMS
Route::get('_admin/firms', [App\Http\Controllers\Admin\FirmController::class, 'index'])->middleware(['auth']);
Route::post('_admin/firms', [App\Http\Controllers\Admin\FirmController::class, 'store'])->middleware(['auth']);
Route::get('_admin/firm/{id}', [App\Http\Controllers\Admin\FirmController::class, 'firm'])->middleware(['auth']);
Route::put('_admin/firm/{id}/update', [App\Http\Controllers\Admin\FirmController::class, 'update'])->middleware(['auth']);
Route::delete('_admin/firm/{id}/delete', [App\Http\Controllers\Admin\FirmController::class, 'delete'])->middleware(['auth']);

// ADMIN VIDEOS
Route::get('_admin/videos', [App\Http\Controllers\Admin\VideoController::class, 'index'])->middleware(['auth']);
Route::post('_admin/videos', [App\Http\Controllers\Admin\VideoController::class, 'store'])->middleware(['auth']);
Route::get('_admin/video/{id}', [App\Http\Controllers\Admin\VideoController::class, 'video'])->middleware(['auth']);
Route::put('_admin/video/{id}/update', [App\Http\Controllers\Admin\VideoController::class, 'update'])->middleware(['auth']);
Route::delete('_admin/video/{id}/delete', [App\Http\Controllers\Admin\VideoController::class, 'delete'])->middleware(['auth']);

// ADMIN CATEGORIES
Route::get('_admin/categories', [App\Http\Controllers\Admin\CategoryController::class, 'index'])->middleware(['auth']);
Route::get('_admin/categories-with-children', [App\Http\Controllers\Admin\CategoryController::class, 'indexWithChildren'])->middleware(['auth']);
Route::post('_admin/categories', [App\Http\Controllers\Admin\CategoryController::class, 'store'])->middleware(['auth']);
Route::get('_admin/category/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'category'])->middleware(['auth']);
Route::put('_admin/category/{id}/update', [App\Http\Controllers\Admin\CategoryController::class, 'update'])->middleware(['auth']);

// ADMIN PRODUCTS
Route::get('_admin/product/{id}', [App\Http\Controllers\Admin\ProductController::class, 'product'])->middleware(['auth']);
Route::get('_admin/products', [App\Http\Controllers\Admin\ProductController::class, 'index'])->middleware(['auth']);
Route::post('_admin/products', [App\Http\Controllers\Admin\ProductController::class, 'store'])->middleware(['auth']);
Route::put('_admin/product/{id}/update', [App\Http\Controllers\Admin\ProductController::class, 'update'])->middleware(['auth']);
Route::delete('_admin/product/{id}/delete', [App\Http\Controllers\Admin\ProductController::class, 'delete'])->middleware(['auth']);

// ADMIN LEADS
Route::get('_admin/leads', [App\Http\Controllers\Admin\LeadController::class, 'index'])->middleware(['auth']);
Route::get('_admin/lead/{id}', [App\Http\Controllers\Admin\LeadController::class, 'lead'])->middleware(['auth']);
Route::put('_admin/lead/{id}/update', [App\Http\Controllers\Admin\LeadController::class, 'update'])->middleware(['auth']);
Route::delete('_admin/lead/{id}/delete', [App\Http\Controllers\Admin\LeadController::class, 'delete'])->middleware(['auth']);

// ADMIN FILE UPLOAD
Route::post('_admin/file/upload', [App\Http\Controllers\Admin\FileController::class, 'store']);

require __DIR__.'/auth.php';
