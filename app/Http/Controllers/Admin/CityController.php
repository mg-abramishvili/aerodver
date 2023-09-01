<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;

class CityController extends Controller
{
    public function index()
    {
        return City::all();
    }

    public function city($id)
    {
        return City::find($id);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'name_eng' => 'required',
            'slug' => 'required',
        ]);

        $city = new City();

        $city->name = $request->name;
        $city->name_eng = $request->name_eng;
        $city->slug = $request->slug;

        $city->save();
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'name_eng' => 'required',
            'slug' => 'required',
        ]);

        $city = City::find($id);

        $city->name = $request->name;
        $city->name_eng = $request->name_eng;
        $city->slug = $request->slug;

        $city->save();
    }
}
