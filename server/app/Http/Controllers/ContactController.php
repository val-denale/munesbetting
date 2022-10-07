<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {

        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'messages' => 'required'
        ]);

        Mail::to('contact@munesbetting.com')->send(new ContactMail($request->firstname, $request->lastname, $request->email, $request->messages));
    }
}
