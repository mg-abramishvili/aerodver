<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return Setting::find(1);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'about_text' => 'required',
            'about_text_eng' => 'required',
            'telegram' => 'required',
            'whatsapp' => 'required',
            'meta_description' => 'required',
        ]);

        $settings = Setting::find(1);

        $settings->about_text = $request->about_text;
        $settings->about_text_eng = $request->about_text_eng;
        $settings->telegram = $request->telegram;
        $settings->whatsapp = $request->whatsapp;
        $settings->vk = $request->vk;
        $settings->youtube = $request->youtube;
        $settings->instagram = $request->instagram;
        $settings->onlyfans = $request->onlyfans;
        $settings->tiktok = $request->tiktok;
        $settings->meta_description = $request->meta_description;
        $settings->header = $request->header;
        $settings->footer = $request->footer;

        $settings->save();
    }
}
