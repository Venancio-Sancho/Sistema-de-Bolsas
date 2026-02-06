<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrador Geral',
            'email' => 'admin@admin.com',
            'password' => Hash::make('123456'),
            'access_level' => 1, // ADMIN
        ]);
    }
}
