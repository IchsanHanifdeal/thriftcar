<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customer';
    protected $primaryKey = 'id_customer';
    protected $fillable = ['id_user', 'nama_lengkap', 'alamat', 'tempat', 'tanggal_lahir', 'pekerjaan', 'no_handphone'];

    public function users()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

}
