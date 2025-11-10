<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperContactMessage
 */
class ContactMessage extends Model
{
    // Bảng này chỉ có created_at, không có updated_at
    public $timestamps = false;

    protected $fillable = [
        'name',
        'email',
        'message',
        'created_at',
    ];
}
