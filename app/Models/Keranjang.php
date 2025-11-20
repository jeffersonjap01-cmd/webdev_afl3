<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Menu;
use App\Models\LokasiToko;
use App\Models\Alamat;
use App\Models\Meja;

class Keranjang extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'menu_id',
        'lokasi_toko_id',
        'alamat_id',
        'meja_id',
        'qty',
        'total_harga',
        'status_pembayaran',
        'order_type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function lokasiToko()
    {
        return $this->belongsTo(LokasiToko::class);
    }

    public function alamat()
    {
        return $this->belongsTo(Alamat::class);
    }

    public function meja()
    {
        return $this->belongsTo(Meja::class);
    }
}
