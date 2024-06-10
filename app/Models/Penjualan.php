<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;
    protected $table = 'penjualan';
    protected $primaryKey = 'id_penjualan';
    protected $fillable = ['id_customer', 'id_mobil', 'tanggal_transaksi', 'cara_pembayaran', 'status_pembayaran', 'dp'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer');
    }

    public function mobil()
    {
        return $this->belongsTo(Mobil::class, 'id_mobil');
    }

}
