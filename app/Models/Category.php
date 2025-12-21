<?php

namespace App\Models;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'parent_id', 'description', 'image'];

    /**
     * Mối quan hệ: Một danh mục Cha có nhiều danh mục Con
     * Ví dụ: Men -> có T-Shirts, Pants...
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Mối quan hệ: Một danh mục Con thuộc về một danh mục Cha
     * Ví dụ: T-Shirts -> thuộc về Men
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Mối quan hệ: Một danh mục có nhiều sản phẩm
     * Links products.category (foreign) to categories.slug (local)
     */
    public function products()
    {
        // hasMany(RelatedModel, ForeignKeyOnRelated, LocalKey)
        // products.category (enum: 'men', 'women'...) -> categories.slug
        return $this->hasMany(Product::class, 'category', 'slug');
    }
}
