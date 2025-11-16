<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_promo',
        'deskripsi',
        'kode_promo',
        'diskon_persen',
        'diskon_nominal',
        'tanggal_mulai',
        'tanggal_berakhir',
        'status',
        'min_pembelian',
        'max_diskon'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_berakhir' => 'date',
        'diskon_persen' => 'decimal:2',
        'diskon_nominal' => 'decimal:2',
    ];

    public function isActive()
    {
        $now = now();
        return $this->status === 'aktif' 
            && $now->gte($this->tanggal_mulai) 
            && $now->lte($this->tanggal_berakhir);
    }
}
