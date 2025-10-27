<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    // Cho phép fill các field này khi cần (an toàn, ngắn gọn)
    protected $fillable = [
        'name',
        'description',
        'price',
        'price_vnd',
        'image',
    ];

    // Cast price để định dạng nhất quán (giữ 2 số thập phân dạng string)
    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
