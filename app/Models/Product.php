<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperProduct
 */
class Product extends Model
{
    use HasFactory, SoftDeletes;

    // Cho phép fill các field này khi cần (an toàn, ngắn gọn)
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'category_id',
        'is_new',
        'is_bestseller',
        'is_on_sale',
    ];

    // Cast price để định dạng nhất quán (giữ 2 số thập phân dạng string)
    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Users who have wishlisted this product.
     */
    public function wishlistedByUsers()
    {
        return $this->belongsToMany(User::class, 'wishlists')
            ->withTimestamps();
    }
}
