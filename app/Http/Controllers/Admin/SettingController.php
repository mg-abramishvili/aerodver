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
        $settings->tiktok = $request->tiktok;
        $settings->dzen = $request->dzen;
        $settings->meta_description = $request->meta_description;
        $settings->header = $request->header;
        $settings->footer = $request->footer;

        $settings->save();
    }

    public function updateAuditArenda(Request $request)
    {
        $this->validate($request, [
            'energoaudit_text' => 'required',
            'energoaudit_gallery' => 'required',
            'energoaudit_icon' => 'required',
            'energoarenda_text' => 'required',
            'energoarenda_gallery' => 'required',
            'energoarenda_icon' => 'required',
        ]);

        $settings = Setting::find(1);

        $settings->energoaudit_text = $request->energoaudit_text;
        $settings->energoaudit_gallery = $request->energoaudit_gallery;
        $settings->energoaudit_icon = $request->energoaudit_icon;
        $settings->energoarenda_text = $request->energoarenda_text;
        $settings->energoarenda_gallery = $request->energoarenda_gallery;
        $settings->energoarenda_icon = $request->energoarenda_icon;

        $settings->save();
    }
}
