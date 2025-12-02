<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Hiển thị trang Contact BluShop
     * GET /contact
     */
    public function show()
    {
        // View đang dùng <x-app-layout> và nằm ở: resources/views/contact.blade.php
        return view('contact');
    }

    /**
     * Xử lý form liên hệ từ trang Contact
     * POST /contact
     */
    public function submit(Request $request)
    {
        // Validate dữ liệu người dùng nhập
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email',
            'topic'    => 'nullable|string|max:100',
            'order_id' => 'nullable|string|max:50',
            'message'  => 'required|string',
        ]);

        // 👉 Tùy bà muốn làm gì tiếp:
        // - Lưu vào database (tạo bảng contact_messages)
        // - Gửi mail cho admin
        // - Ghi log để debug
        //
        // Ví dụ tạm: ghi log để chắc chắn form hoạt động
        // \Log::info('New contact message', $data);

        // Sau khi xử lý xong, redirect về lại trang Contact + flash message
        return back()->with('success', 'Cám ơn bạn đã liên hệ BluShop. Chúng tôi đã nhận được tin nhắn của bạn!');
    }
}
