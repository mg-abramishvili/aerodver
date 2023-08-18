<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AgeController extends Controller
{
    public function index()
    {
        return session()->get('age');
    }

    public function store(Request $request)
    {
        if($request->age)
        {
            session()->put('age', '18');
        }
    }
}
