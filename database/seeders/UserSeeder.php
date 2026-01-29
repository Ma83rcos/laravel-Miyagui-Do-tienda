<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Administrador
        User::updateOrCreate(
            ['email' => 'admin@miyagui.com'],
            [
                'name' => 'Bosh',
                'password' => Hash::make('admin'),
                'role' => 'admin',
            ]
        );

        // Usuario regular
        User::updateOrCreate(
            ['email' => 'user@miyagui.com'],
            [
                'name' => 'User Register',
                'password' => Hash::make('user123'),
                'role' => 'user',
            ]
        );
    }
}
