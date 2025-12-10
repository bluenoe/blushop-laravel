<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    public function index()
    {
        // Lấy toàn bộ settings và chuyển về dạng mảng [key => value] để dễ dùng trong View
        $settings = Setting::all()->pluck('value', 'key');

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        // Danh sách các key được phép lưu
        $allowedKeys = [
            'shop_name',
            'shop_email',
            'shop_phone',
            'shop_address',
            'shipping_fee',
            'free_shipping_threshold',
            'facebook_url',
            'instagram_url'
        ];

        foreach ($request->all() as $key => $value) {
            if (in_array($key, $allowedKeys)) {
                Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value]
                );
            }
        }

        // Xóa cache nếu có dùng cache
        Cache::forget('settings');

        return back()->with('success', 'Settings updated successfully.');
    }
}
