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
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'role' => 'admin',
        ]);

        User::Create([
            'email' => 'customer@gmail.com',
            'password' => Hash::make('customer'),
            'role' => 'customer',
        ]);
        
        User::Create([
            'email' => 'pimpinan@gmail.com',
            'password' => Hash::make('pimpinan'),
            'role' => 'pimpinan',
        ]);
        
        User::Create([
            'email' => 'sales@gmail.com',
            'password' => Hash::make('sales'),
            'role' => 'sales',
        ]);
    }
}
