<?php

namespace App\Models;

use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'sale_price',
        'cost_price',
        'sku',
        'stock',
        'category_id',
        'is_active',
        'is_featured',
        'is_on_sale',
        'is_new',
        'specifications',
        'care_guide',
        'avg_rating',
        'review_count',
        'views_count',
        'meta_title',
        'meta_description',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'stock' => 'integer',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_on_sale' => 'boolean',
        'is_new' => 'boolean',
        'specifications' => 'array',
        'avg_rating' => 'decimal:1',
        'review_count' => 'integer',
        'views_count' => 'integer',
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
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

    /**
     * Get all images for the product.
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    /**
     * Get available colors for the product.
     */
    public function colors()
    {
        return $this->belongsToMany(Color::class, 'product_colors')
            ->withPivot('stock')
            ->withTimestamps();
    }

    /**
     * Get available sizes for the product.
     */
    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'product_sizes')
            ->withPivot('stock')
            ->withTimestamps();
    }

    /**
     * Get all reviews for the product.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get products for "Complete the Look" section.
     */
    public function completeLookProducts()
    {
        return $this->belongsToMany(
            Product::class,
            'complete_look',
            'product_id',
            'related_product_id'
        )->withTimestamps();
    }

    /**
     * Get related products (inverse relationship).
     */
    public function relatedToProducts()
    {
        return $this->belongsToMany(
            Product::class,
            'complete_look',
            'related_product_id',
            'product_id'
        );
    }

    /**
     * Get users who wishlisted this product.
     */
    public function wishlistedBy()
    {
        return $this->belongsToMany(User::class, 'wishlists')
            ->withTimestamps();
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors & Mutators
    |--------------------------------------------------------------------------
    */

    /**
     * Get the product's display price.
     */
    public function getDisplayPriceAttribute()
    {
        return $this->is_on_sale && $this->sale_price
            ? $this->sale_price
            : $this->price;
    }

    /**
     * Check if product is in stock.
     */
    public function getInStockAttribute()
    {
        return $this->stock > 0;
    }

    /**
     * Get discount percentage if on sale.
     */
    public function getDiscountPercentAttribute()
    {
        if ($this->is_on_sale && $this->sale_price && $this->price > 0) {
            return round((($this->price - $this->sale_price) / $this->price) * 100);
        }
        return 0;
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Scope a query to only include active products.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include featured products.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope a query to only include new products.
     */
    public function scopeNew($query)
    {
        return $query->where('is_new', true);
    }

    /**
     * Scope a query to only include products on sale.
     */
    public function scopeOnSale($query)
    {
        return $query->where('is_on_sale', true);
    }

    /**
     * Scope a query to filter by category.
     */
    public function scopeInCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Scope a query to search products.
     */
    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
                ->orWhere('description', 'like', "%{$term}%")
                ->orWhere('sku', 'like', "%{$term}%");
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Check if user has wishlisted this product.
     */
    public function isWishlistedBy($userId)
    {
        return $this->wishlistedBy()->where('user_id', $userId)->exists();
    }

    /**
     * Check if user has reviewed this product.
     */
    public function isReviewedBy($userId)
    {
        return $this->reviews()->where('user_id', $userId)->exists();
    }
}
