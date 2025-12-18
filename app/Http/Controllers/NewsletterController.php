<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscriber;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        // Validation chuẩn
        $request->validate([
            'email' => 'required|email|unique:subscribers,email'
        ], [
            'email.required' => 'Email is required.',
            'email.email'    => 'Invalid email format.',
            'email.unique'   => 'You are already on the list.', // Message thân thiện hơn
        ]);

        Subscriber::create([
            'email' => $request->email,
            'is_subscribed' => true
        ]);

        return response()->json([
            'message' => 'Thank you! You have been subscribed.'
        ]);
    }
}
