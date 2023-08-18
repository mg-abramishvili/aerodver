<?php

namespace App\Http\Controllers\Admin;

use App\Models\MainBanner;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainBannerController extends Controller
{
    public function index()
    {
        return MainBanner::all();
    }

    public function mainbanner($id)
    {
        return MainBanner::find($id);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'title_eng' => 'required',
        ]);

        $mainbanner = new MainBanner();

        $mainbanner->title = $request->title;
        $mainbanner->title_eng = $request->title_eng;
        $mainbanner->subtitle = $request->subtitle;
        $mainbanner->subtitle_eng = $request->subtitle_eng;

        $mainbanner->save();
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'title_eng' => 'required',
        ]);

        $mainbanner = MainBanner::find($id);

        $mainbanner->title = $request->title;
        $mainbanner->title_eng = $request->title_eng;
        $mainbanner->subtitle = $request->subtitle;
        $mainbanner->subtitle_eng = $request->subtitle_eng;

        $mainbanner->save();
    }
}
