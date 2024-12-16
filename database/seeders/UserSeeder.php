<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::Create([
            'nama' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'role' => 'admin',
        ]);

        User::Create([
            'nama' => 'Nico Jonathan',
            'email' => 'customer@gmail.com',
            'password' => Hash::make('customer'),
            'role' => 'customer',
        ]);
        
        User::Create([
            'nama' => 'pimpinan',
            'email' => 'pimpinan@gmail.com',
            'password' => Hash::make('pimpinan'),
            'role' => 'pimpinan',
        ]);
        
        User::Create([
            'nama' => 'Rafli',
            'email' => 'sales@gmail.com',
            'password' => Hash::make('sales'),
            'role' => 'sales',
        ]);

        User::Create([
            'nama' => 'Bilgrandov',
            'email' => 'sales2@gmail.com',
            'password' => Hash::make('sales'),
            'role' => 'sales',
        ]);
        User::Create([
            'nama' => 'Kelvin Kiswanda',
            'email' => 'sales3@gmail.com',
            'password' => Hash::make('sales'),
            'role' => 'sales',
        ]);
    }
}
