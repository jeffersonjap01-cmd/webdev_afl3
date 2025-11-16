<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'meja_id',
        'status',
        'status_pembayaran',
        'last_activity_at'
    ];

    protected $casts = [
        'last_activity_at' => 'datetime',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Meja
    public function meja()
    {
        return $this->belongsTo(Meja::class);
    }

    // Update last_activity_at setiap kali order berubah
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($order) {
            $order->last_activity_at = now();
        });
    }
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
