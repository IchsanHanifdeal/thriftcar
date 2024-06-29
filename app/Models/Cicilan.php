<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cicilan extends Model
{
    use HasFactory;
    protected $table = 'cicilan';
    protected $primaryKey = 'id_cicilan';
    protected $fillable = ['id_customer', 'id_penjualan', 'tenor', 'jatuh_tempo', 'tanggal_pembayaran', 'jumlah_cicilan', 'jumlah_pembayaran', 'status_cicilan', 'bukti_pembayaran'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer');
    }

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'id_penjualan');
    }

}
