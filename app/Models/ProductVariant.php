<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id',
        'capacity_ml',
        'price',
        'compare_at_price',
        'stock_quantity',
        'sku',
        'is_active',
        'color_name', // Added
        'hex_code',   // Added
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Format hiển thị tên đầy đủ: "Chanel No.5 - 50ml"
    public function getFullNameAttribute()
    {
        return "{$this->product->name} - {$this->capacity_ml}ml";
    }
}
