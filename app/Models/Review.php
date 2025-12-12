<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'rating',
        'content',
    ];

    // Quan hệ ngược về product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // (tuỳ nếu cần) quan hệ với user
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
