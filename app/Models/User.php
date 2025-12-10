<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

/**
 * @mixin IdeHelperUser
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'avatar',
        'phone_number',
        'gender',
        'birth_date',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'birth_date' => 'date',
        ];
    }

    /**
     * Get the public URL to the user's avatar with cache-busting.
     */
    public function avatarUrl(?int $version = null): ?string
    {
        if (! $this->avatar) {
            return null;
        }

        $url = Storage::url($this->avatar);
        $v = $version ?? optional($this->updated_at)->getTimestamp() ?? time();

        return $url . '?v=' . $v;
    }

    /**
     * Orders placed by the user.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    /**
     * The products that the user has in their wishlist.
     */

    // 1. Hàm chính (Dùng cho nút bấm Wishlist Toggle)
    public function wishlist()
    {
        // Giả sử bảng trung gian tên là 'wishlists'
        return $this->belongsToMany(Product::class, 'wishlists', 'user_id', 'product_id')
            ->withTimestamps();
    }

    // 2. Hàm phụ (Alias - Dùng cho trang Profile để không bị lỗi code cũ)
    public function wishlistedProducts()
    {
        return $this->wishlist();
    }
}
