<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Cho phép fill các field này khi cần (an toàn, ngắn gọn)
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
    ];

    // Cast price để định dạng nhất quán (giữ 2 số thập phân dạng string)
    protected $casts = [
        'price' => 'decimal:2',
    ];
}
