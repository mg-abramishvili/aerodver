<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Firm;

class FirmController extends Controller
{
    public function index()
    {
        return Firm::all();
    }

    public function firm($id)
    {
        return Firm::find($id);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'city_id' => 'required',
            'name' => 'required',
            'name_eng' => 'required',
            'address' => 'required',
            'tel' => 'required',
            'price' => 'required',
        ]);

        $firm = new Firm();

        $firm->city_id = $request->city_id;
        $firm->name = $request->name;
        $firm->name_eng = $request->name_eng;
        $firm->address = $request->address;
        $firm->tel = $request->tel;
        $firm->whatsapp = $request->whatsapp;
        $firm->price = $request->price;
        $firm->gallery = $request->gallery;
        $firm->videogallery = $request->videogallery;
        $firm->description = $request->description;
        $firm->description2 = $request->description2;

        $firm->save();
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'city_id' => 'required',
            'name' => 'required',
            'name_eng' => 'required',
            'address' => 'required',
            'tel' => 'required',
            'price' => 'required',
        ]);

        $firm = Firm::find($id);

        $firm->city_id = $request->city_id;
        $firm->name = $request->name;
        $firm->name_eng = $request->name_eng;
        $firm->address = $request->address;
        $firm->tel = $request->tel;
        $firm->whatsapp = $request->whatsapp;
        $firm->price = $request->price;
        $firm->gallery = $request->gallery;
        $firm->videogallery = $request->videogallery;
        $firm->description = $request->description;
        $firm->description2 = $request->description2;

        $firm->save();
    }
}
