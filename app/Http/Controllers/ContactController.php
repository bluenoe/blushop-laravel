<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log; // Import Log để ghi nhật ký hệ thống
use App\Models\ContactMessage;       // Import Model

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
        // 1. Validate dữ liệu đầu vào
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email'],
            'topic'    => ['nullable', 'string', 'max:100'],
            'order_id' => ['nullable', 'string', 'max:50'],
            'message'  => ['required', 'string'],
        ]);

        try {
            // 2. Chuẩn bị data (Merge thêm thông tin hệ thống)
            // Lấy IP người dùng để sau này trace được spammer
            $data = array_merge($validated, [
                'ip_address' => $request->ip(),
                'status'     => 'new' // Mặc định là tin mới
            ]);

            // 3. Lưu vào database
            ContactMessage::create($data);

            // 4. Ghi log (Best practice: Luôn log lại các hành động quan trọng)
            Log::info("New contact message submitted by {$validated['email']}");

            // TODO: Gửi email thông báo cho Admin (Nên dùng Queue sau này)

            return back()->with(
                'success',
                'Cám ơn bạn đã liên hệ BluShop. Chúng tôi đã nhận được tin nhắn của bạn!'
            );
        } catch (\Exception $e) {
            // Nếu lỗi DB, ghi log lỗi để dev check, nhưng báo lỗi chung chung cho user
            Log::error("Contact form error: " . $e->getMessage());

            return back()->withInput()->with(
                'error',
                'Có lỗi xảy ra khi gửi tin nhắn. Vui lòng thử lại sau.'
            );
        }
    }
}
