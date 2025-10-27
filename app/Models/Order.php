<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'code', 'name', 'address', 'total_vnd', 'status'
    ];

    public function items(): HasMany {
        return $this->hasMany(OrderItem::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
