<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    // Định nghĩa các hằng số để tránh gõ sai (Nếu chưa dùng Enum)
    const STATUS_PENDING = 'pending';
    const STATUS_PAID = 'paid';
    const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'user_id',
        'total_amount',
        'payment_status',
        'status',
        'shipping_address',
        'cancellation_reason',
        'cancelled_at',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'cancelled_at' => 'datetime',
        // 'status' => OrderStatus::class, // Mở comment nếu bà dùng Enum
    ];

    public function isCancellable(): bool
    {
        // So sánh với hằng số hoặc Enum, không so sánh với chuỗi trần
        return $this->status === self::STATUS_PENDING;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function contactMessages(): HasMany
    {
        return $this->hasMany(ContactMessage::class);
    }
}