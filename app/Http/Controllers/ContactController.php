<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use App\Models\ContactMessage;
use Illuminate\Validation\Rule; // Import cái này để validate nâng cao

class ContactController extends Controller
{
    public function show(): View
    {
        return view('contact');
    }

    public function submit(Request $request): RedirectResponse
    {
        // 1. Validate dữ liệu đầu vào (QUAN TRỌNG: Đã sửa logic order_id)
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255'],
            'topic'    => ['nullable', 'string', 'max:100'],
            
            // Refactor order_id
            // - integer: Bắt buộc phải là số.
            // - exists:orders,id: Bắt buộc số này phải TỒN TẠI trong bảng orders.
            'order_id' => ['nullable', 'integer', 'exists:orders,id'], 
            
            'message'  => ['required', 'string'],
        ], [
            // Custom thông báo lỗi cho thân thiện (Optional)
            'order_id.exists' => 'Mã đơn hàng này không tồn tại trong hệ thống.',
            'order_id.integer' => 'Mã đơn hàng phải là một dãy số.',
        ]);

        try {
            // 2. Chuẩn bị data
            // Tip: Dùng request()->ip() ở đây là chuẩn, an toàn hơn lấy từ input
            $data = $validated;
            $data['ip_address'] = $request->ip();
            $data['status'] = 'new'; // Sau này nên thay bằng Enum: ContactStatus::NEW

            // 3. Lưu vào database
            ContactMessage::create($data);

            // 4. Ghi log
            Log::info("New contact message submitted", [
                'email' => $validated['email'],
                'order_id' => $validated['order_id'] ?? 'N/A'
            ]);

            return back()->with(
                'success',
                'Cám ơn bạn đã liên hệ BluShop. Chúng tôi đã nhận được tin nhắn của bạn!'
            );
        } catch (\Exception $e) {
            // Ghi full stack trace để debug
            Log::error("Contact form error: " . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return back()->withInput()->with(
                'error',
                'Có lỗi xảy ra khi gửi tin nhắn. Vui lòng thử lại sau.'
            );
        }
    }
}