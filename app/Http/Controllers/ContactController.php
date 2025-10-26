<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Hiển thị form liên hệ.
     */
    public function index()
    {
        return view('contact');
    }

    /**
     * Lưu message vào DB, hiện flash success.
     */
    public function send(Request $request)
    {
        $data = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'email', 'max:255'],
            'message' => ['required', 'string', 'min:5'],
        ]);

        ContactMessage::create([
            'name'       => $data['name'],
            'email'      => $data['email'],
            'message'    => $data['message'],
            'created_at' => now(),
        ]);

        return redirect()
            ->route('contact.index')
            ->with('success', 'Your message has been sent. Thank you!');
    }
}
