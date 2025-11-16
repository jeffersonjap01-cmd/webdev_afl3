<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LokasiToko extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_lokasi',
        'alamat',
        'no_telepon'
    ];

    // Relasi ke Menu
    public function menus()
    {
        return $this->hasMany(Menu::class);
    }
}
