<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'topic',
        'order_id',
        'message',
        'ip_address',
        'status',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
