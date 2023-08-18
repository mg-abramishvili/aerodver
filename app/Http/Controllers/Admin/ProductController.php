<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return Product::orderBy('view_counter', 'desc')->get();
    }

    public function product($id)
    {
        return Product::with('category')->find($id);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'name_eng' => 'required',
            'slug' => 'required',
            'description' => 'required',
            'description_eng' => 'required',
            'price_rub' => 'required',
            'price_usd' => 'required',
            'category_id' => 'required',
            'order' => 'required',
            'gallery' => 'required',
        ]);

        if(Product::where('slug', $request->slug)->exists()) {
            return 'slug error';
        }

        $product = new Product();

        $product->name = $request->name;
        $product->name_eng = $request->name_eng;
        $product->subname = $request->subname;
        $product->subname_eng = $request->subname_eng;
        $product->slug = $request->slug;
        $product->description = $request->description;
        $product->description_eng = $request->description_eng;
        $product->price_rub = $request->price_rub;
        $product->price_usd = $request->price_usd;
        $product->category_id = $request->category_id;
        $product->order = $request->order;
        $product->video = $request->video;

        if (!isset($request->gallery)) {
            $request->gallery = [];
        }
        $product->gallery = $request->gallery;

        $product->save();
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'name_eng' => 'required',
            'slug' => 'required',
            'description' => 'required',
            'description_eng' => 'required',
            'price_rub' => 'required',
            'price_usd' => 'required',
            'category_id' => 'required',
            'order' => 'required',
            'gallery' => 'required',
        ]);

        if(Product::where('id', '!=', $id)->where('slug', $request->slug)->exists()) {
            return 'slug error';
        }

        $product = Product::find($id);

        $product->name = $request->name;
        $product->name_eng = $request->name_eng;
        $product->subname = $request->subname;
        $product->subname_eng = $request->subname_eng;
        $product->slug = $request->slug;
        $product->description = $request->description;
        $product->description_eng = $request->description_eng;
        $product->price_rub = $request->price_rub;
        $product->price_usd = $request->price_usd;
        $product->category_id = $request->category_id;
        $product->order = $request->order;
        $product->video = $request->video;

        if (!isset($request->gallery)) {
            $request->gallery = [];
        }
        $product->gallery = $request->gallery;

        $product->save();
    }

    public function delete($id)
    {
        $product = Product::find($id);

        $product->delete();
    }
}
