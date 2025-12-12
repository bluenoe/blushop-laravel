<?php

namespace App\Models;

use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

/**
 * @mixin \Eloquent
 * @mixin IdeHelperProduct
 */
class Product extends Model
{
    use HasFactory, SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'category_id',
        'is_new',
        'is_bestseller',
        'is_on_sale',
        'specifications', // Đừng quên thêm field này vào fillable nếu bạn muốn lưu nó
    ];

    /**
     * Sửa lỗi: Gộp tất cả casts vào một mảng duy nhất.
     * Bổ sung cast boolean cho các cờ (flag) để đảm bảo dữ liệu luôn đúng kiểu.
     */
    protected $casts = [
        'price'          => 'decimal:2',
        'specifications' => 'array',
        'is_on_sale'     => 'boolean',
        'is_new'         => 'boolean',       // Best practice: cast luôn các flag này
        'is_bestseller'  => 'boolean',       // Best practice: cast luôn các flag này
        'is_approved'    => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function images()
    {
        // Giả sử bà có bảng product_images
        return $this->hasMany(ProductImage::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews(): HasMany
    {
        // Lưu ý: Việc hardcode 'where' vào relation chuẩn là tiện,
        // nhưng cẩn thận khi admin muốn xem cả review chưa duyệt.
        return $this->hasMany(Review::class)
            ->where('is_approved', true)
            ->latest();
    }

    /**
     * Users who have wishlisted this product.
     */
    public function wishlistedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'wishlists')
            ->withTimestamps();
    }

    /**
     * Lấy sản phẩm "Complete the Look"
     */
    public function completeLookProducts(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_relations', 'parent_product_id', 'child_product_id')
            ->wherePivot('type', 'complete_look');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /**
     * Logic lấy sản phẩm tương tự (Tự động theo Category, trừ chính nó)
     * Sử dụng: Product::related($product)->get();
     */
    public function scopeRelated(Builder $query, Product $product): Builder
    {
        return $query->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->take(8);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS & MUTATORS
    |--------------------------------------------------------------------------
    */

    /**
     * Hàm tính điểm trung bình sao
     * Lưu ý hiệu năng: Gọi cái này trong vòng lặp (list sản phẩm) sẽ gây lỗi N+1 query.
     * Nên dùng withAvg('reviews', 'rating') khi query từ Controller thì tốt hơn.
     */
    public function getAvgRatingAttribute(): float
    {
        // Dùng relation đã load nếu có để tránh query lại (Eager loading check)
        if ($this->relationLoaded('reviews')) {
            return $this->reviews->avg('rating') ?? 0;
        }

        return $this->reviews()->avg('rating') ?? 0;
    }

    /**
     * Hàm tính độ vừa vặn trung bình
     */
    public function getAvgFitAttribute(): float
    {
        if ($this->relationLoaded('reviews')) {
            return $this->reviews->avg('fit_rating') ?? 3;
        }

        return $this->reviews()->avg('fit_rating') ?? 3;
    }
}
