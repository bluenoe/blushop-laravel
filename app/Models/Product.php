<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * @mixin IdeHelperProduct
 */
class Product extends Model
{
    use HasFactory, SoftDeletes;

    // Cho phép fill các field này khi cần (an toàn, ngắn gọn)
    protected $fillable = [
        'name',
        'slug',
        'sku',
        'description',
        'base_price',     // Fixed: was 'price'
        'image',
        'category',       // Fixed: was 'category_id' - now stores enum string ('men', 'women', 'fragrance')
        'stock',
        'is_active',
        'is_new',
        'is_bestseller',
        'is_on_sale',
        'avg_rating',
        'reviews_count',
    ];

    // Cast base_price để định dạng nhất quán (giữ 2 số thập phân dạng string)
    protected $casts = [
        'base_price' => 'decimal:2', // Fixed: was 'price'
        'specifications' => 'array',
        'is_active' => 'boolean',
        'is_new' => 'boolean',
        'is_bestseller' => 'boolean',
        'is_on_sale' => 'boolean',
    ];

    // Trong Product.php
    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                // 1. Lấy biến thể đầu tiên ra (Lúc này mới gọi được nè)
                $variant = $this->variants->first();

                // 2. Ưu tiên: Nếu có Variant và Variant có đường dẫn ảnh
                if ($variant && $variant->image_path) {
                    return Storage::url($variant->image_path);
                }
                // 3. Fallback: Nếu không có variant, lấy ảnh gốc của Product
                if ($this->image) {
                    // Kiểm tra xem trong DB đã có chữ 'products/' chưa để tránh trùng
                    $path = str_starts_with($this->image, 'products/')
                        ? $this->image
                        : 'products/' . $this->image;

                    return Storage::url($path);
                }

                // 4. Đường cùng: Trả về ảnh giữ chỗ (Placeholder) để web không bị vỡ khung
                return 'https://placehold.co/600x800?text=No+Image';
            }
        );
    }

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

    public function completeLookProducts()
    {
        // pivot table: complete_look_product (xem migration bên dưới)
        return $this->belongsToMany(
            Product::class,
            'complete_look_product',
            'product_id',       // product chính
            'look_product_id'   // product trong "complete the look"
        )->withTimestamps();
    }

    public function reviews()
    {
        return $this->hasMany(\App\Models\Review::class);
    }
    // Thêm quan hệ với ProductImage
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }


    // 2. Relationship: Một chai nước hoa có nhiều biến thể (size)
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    // Hàm lấy chi tiết sản phẩm kèm variants và ảnh chuẩn
    public function getProductDetails($slug)
    {
        return self::with(['variants.image', 'images'])
            ->where('slug', $slug)
            ->firstOrFail();
    }

    // 3. Helper: Lấy giá thấp nhất để hiển thị "Từ 1.000.000đ" ở trang danh sách
    public function getMinPriceAttribute()
    {
        // Cache lại hoặc query nhẹ, tránh N+1 query
        return $this->variants->min('price');
    }
}
