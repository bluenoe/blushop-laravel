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

        return $url.'?v='.$v;
    }

    /**
     * Orders placed by the user.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Products the user has wishlisted.
     */
    public function wishlistedProducts()
    {
        return $this->belongsToMany(Product::class, 'wishlists')
            ->withTimestamps();
    }

    /**
     * Check if product is in user's wishlist.
     */
    public function hasWishlisted(int $productId): bool
    {
        return $this->wishlistedProducts()->where('products.id', $productId)->exists();
    }
}
