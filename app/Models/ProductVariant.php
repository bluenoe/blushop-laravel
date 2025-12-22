<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id',
        'capacity_ml',
        'size',
        'price',
        'stock',
        'sku',
        'image_path',
        'color_name',
        'color_hex',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function image()
{
    // Link tới bảng product_images thông qua image_id vừa tạo
    return $this->belongsTo(ProductImage::class, 'image_id');
}

    // Format hiển thị tên đầy đủ: "Chanel No.5 - 50ml"
    public function getFullNameAttribute()
    {
        return "{$this->product->name} - {$this->capacity_ml}ml";
    }
}
