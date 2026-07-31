<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {

        // Admin
        User::updateOrCreate(
            [
                'email' => 'admin@gmail.com'
            ],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('admin001'),
                'role' => 'admin',
                'email_verified_at' => null,
                'verification_code' => null,
            ]
        );


        // Cashier
        User::updateOrCreate(
            [
                'email' => 'cashier@gmail.com'
            ],
            [
                'name' => 'Cashier User',
                'password' => Hash::make('cashier001'),
                'role' => 'cashier',
                'email_verified_at' => null,
                'verification_code' => null,
            ]
        );


        // Chef
        User::updateOrCreate(
            [
                'email' => 'chef@gmail.com'
            ],
            [
                'name' => 'Chef User',
                'password' => Hash::make('chef001'),
                'role' => 'chef',
                'email_verified_at' => null,
                'verification_code' => null,
            ]
        );

    }
}