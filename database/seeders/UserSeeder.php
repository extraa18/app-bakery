<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['Dewi Lestari', 'admin@bakery.test', 'admin'],
            ['Budi Santoso', 'kasir1@bakery.test', 'kasir'],
            ['Sari Wulandari', 'kasir2@bakery.test', 'kasir'],
        ];

        foreach ($users as [$name, $email, $role]) {
            User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $name,
                    'password' => Hash::make('password'),
                    'role' => $role,
                ]
            );
        }
    }
}