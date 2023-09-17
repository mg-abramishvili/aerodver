<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use App\Mail\LeadMail;
use Illuminate\Support\Facades\Mail;

class LeadController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'tel' => 'required',
        ]);

        $lead = new Lead();

        $lead->name = $request->name;
        $lead->tel = $request->tel;

        if($request->subject) {
            $lead->subject = $request->subject;
        } else {
            $lead->subject = "Заявка с сайта";
        }

        if($request->order)
        {
            $lead->order = $request->order;
        }

        $lead->save();

        if($request->order)
        {
            session()->forget('cart');
        }

        Mail::to('aerodver.ru@mail.ru')->send(new LeadMail($lead));
    }
}