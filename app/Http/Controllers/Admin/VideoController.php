<?php

namespace App\Http\Controllers\Admin;

use App\Models\Video;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index()
    {
        return Video::all();
    }

    public function video($id)
    {
        return Video::find($id);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'name_eng' => 'required',
            'video' => 'required',
            'image' => 'required',
        ]);

        $video = new Video();

        $video->name = $request->name;
        $video->name_eng = $request->name_eng;
        $video->description = $request->description;
        $video->description_eng = $request->description_eng;
        $video->video = $request->video;
        $video->image = $request->image;

        $video->save();
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'name_eng' => 'required',
            'video' => 'required',
            'image' => 'required',
        ]);

        $video = Video::find($id);

        $video->name = $request->name;
        $video->name_eng = $request->name_eng;
        $video->description = $request->description;
        $video->description_eng = $request->description_eng;
        $video->video = $request->video;
        $video->image = $request->image;

        $video->save();
    }

    public function delete($id)
    {
        $video = Video::find($id);

        $video->delete();
    }
}
