<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        return Page::all();
    }

    public function page($id)
    {
        return Page::find($id);
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'content' => 'required',
        ]);

        $page = Page::find($id);

        $page->name = $request->name;
        $page->content = $request->content;

        if (!isset($request->gallery)) {
            $request->gallery = [];
        }
        $page->gallery = $request->gallery;

        $page->save();
    }
}
