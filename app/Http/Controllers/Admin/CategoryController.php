<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return Category::where('parent_id', null)->orderBy('order', 'asc')->get();
    }

    public function indexWithChildren()
    {
        return Category::where('parent_id', null)->with('children')->orderBy('order', 'asc')->get();
    }

    public function category($id)
    {
        return Category::with('children', 'products')->find($id);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'name_eng' => 'required',
            'slug' => 'required',
            'order' => 'required',
            'image' => 'required',
        ]);

        if(Category::where('slug', $request->slug)->exists()) {
            return 'slug error';
        }

        $category = new Category();

        $category->name = $request->name;
        $category->name_eng = $request->name_eng;
        $category->slug = $request->slug;
        $category->description = $request->description;
        $category->order = $request->order;
        $category->image = $request->image;

        if(isset($request->parent_id)) {
            $category->parent_id = $request->parent_id;
        }

        $category->save();

        return $category->id;
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'name_eng' => 'required',
            'slug' => 'required',
            'order' => 'required',
            'image' => 'required',
        ]);
        
        if(Category::where('id', '!=', $id)->where('slug', $request->slug)->exists()) {
            return 'slug error';
        }

        $category = Category::find($id);

        $category->name = $request->name;
        $category->name_eng = $request->name_eng;
        $category->slug = $request->slug;
        $category->description = $request->description;
        $category->order = $request->order;
        $category->image = $request->image;

        if(isset($request->parent_id)) {
            $category->parent_id = $request->parent_id;
        }
        
        $category->save();
    }
}
