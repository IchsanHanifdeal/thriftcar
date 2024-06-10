<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mobil extends Model
{
    use HasFactory;
    protected $table = 'mobil';
    protected $primaryKey = 'id_mobil';
    protected $fillable = ['gambar', 'nama_mobil', 'tipe_mobil', 'merk_mobil', 'warna', 'transmisi', 'stok', 'harga'];

    public function penjualans()
    {
        return $this->hasMany(Penjualan::class, 'id_mobil');
    }
}
