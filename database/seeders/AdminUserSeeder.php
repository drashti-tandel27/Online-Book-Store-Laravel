<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'admin@bookstore.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'phone' => '1234567890',
                'address' => 'Admin Address',
                'is_admin' => true,
            ]
        );
    }
}