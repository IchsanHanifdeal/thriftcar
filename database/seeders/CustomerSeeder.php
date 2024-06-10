<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::create([
            'id_user' => '2',
            'nama_lengkap' => 'Nico Jonathan',
            'alamat' => 'Jl. Bangau Sakti',
            'tempat' => 'Rumah Sakit',
            'tanggal_lahir' => now(),
            'pekerjaan' => 'Beban Keluarga',
            'no_handphone' => '08123456789',
        ]);
    }
}
