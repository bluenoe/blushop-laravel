<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    // Định nghĩa các hằng số để tránh gõ sai (Nếu chưa dùng Enum)
    const STATUS_PENDING = 'pending';
    const STATUS_PAID = 'paid';
    const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'user_id',
        'order_code',
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
    ];

    /**
     * Boot the model: auto-generate a unique order_code on creation.
     */
    protected static function booted(): void
    {
        static::creating(function (Order $order) {
            if (empty($order->order_code)) {
                $order->order_code = static::generateUniqueCode();
            }
        });
    }

    /**
     * Generate a unique order code.
     * Format: ORD-YYYYMMDD-XXXX (e.g., ORD-20260305-A1B2)
     *
     * Uses a while loop to guarantee uniqueness against the database.
     */
    public static function generateUniqueCode(): string
    {
        $datePrefix = 'ORD-' . now()->format('Ymd') . '-';

        do {
            // Generate 4-char uppercase alphanumeric suffix
            $code = $datePrefix . strtoupper(Str::random(4));
        } while (static::where('order_code', $code)->exists());

        return $code;
    }

    /**
     * Use order_code for route model binding instead of id.
     */
    public function getRouteKeyName(): string
    {
        return 'order_code';
    }

    public function isCancellable(): bool
    {
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