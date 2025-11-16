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
        'stok'
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

}
