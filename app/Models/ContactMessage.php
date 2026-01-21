<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'topic',
        'order_id', // Đã update đúng theo DB mới
        'message',
        'ip_address',
        'status',
    ];

    protected $casts = [
        'order_id' => 'integer', // Ép kiểu cho chắc
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}