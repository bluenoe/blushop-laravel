<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactController extends Controller
{
    /**
     * Hiển thị trang Contact BluShop.
     */
    public function show(): View
    {
        return view('contact');
    }

    /**
     * Xử lý form liên hệ từ trang Contact.
     */
    public function submit(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email'],
            'topic'    => ['nullable', 'string', 'max:100'],
            'order_id' => ['nullable', 'string', 'max:50'],
            'message'  => ['required', 'string'],
        ]);

        // TODO:
        // - Lưu $validated vào database (contact_messages)
        // - Gửi mail cho admin
        // - Ghi log nếu cần debug

        return back()->with(
            'success',
            'Cám ơn bạn đã liên hệ BluShop. Chúng tôi đã nhận được tin nhắn của bạn!'
        );
    }
}
