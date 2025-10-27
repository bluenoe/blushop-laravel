<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactSendRequest;
use App\Models\ContactMessage;

class ContactController extends Controller
{
    public function index() {
        return view('contact');
    }

    public function send(ContactSendRequest $request) {
        ContactMessage::create($request->only(['name','email','message']));
        return back()->with('success', 'Message sent!');
    }
}
