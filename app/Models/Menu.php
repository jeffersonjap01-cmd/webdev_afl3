<?php

namespace App\Models;

use App\Models\Keranjang;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'gambar',
        'nama',
        'deskripsi',
        'harga',
        'stok',
        'kategori_id',
        'lokasi_toko_id'
    ];

    public $timestamps = false;

    public function keranjang()
    {
        return $this->hasMany(Keranjang::class);
    }

    public function lokasiToko()
    {
        return $this->belongsTo(LokasiToko::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
