<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    /**
     * Lấy tất cả settings từ Cache, lưu trữ 24 giờ.
     */
    public static function getAllSettings(): array
    {
        return Cache::remember('settings', 60 * 60 * 24, function () {
            return self::pluck('value', 'key')->toArray();
        });
    }

    /**
     * Lấy giá trị của một setting cụ thể, nếu không có trả về $default.
     */
    public static function getVal(string $key, $default = null)
    {
        $settings = self::getAllSettings();
        return $settings[$key] ?? $default;
    }
}
