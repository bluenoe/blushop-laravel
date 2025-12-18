<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscriber;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        // 1. Validate dữ liệu
        $request->validate([
            'email' => 'required|email|unique:subscribers,email'
        ], [
            'email.required' => 'Please enter your email.',
            'email.email' => 'Invalid email format.',
            'email.unique' => 'This email is already subscribed.',
        ]);

        // 2. Lưu vào DB
        Subscriber::create([
            'email' => $request->email,
            'is_subscribed' => true
        ]);

        // 3. Trả về JSON để Frontend (AlpineJS) đọc
        return response()->json([
            'message' => 'Thank you for subscribing!'
        ]);
    }
}
