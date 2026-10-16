<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Membuat akun awal administrator untuk masuk ke panel admin toko bahan bangunan.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@berkahbangunan.com'],
            [
                'name'     => 'Administrator Toko',
                'password' => Hash::make('password123'),
            ]
        );
    }
}
