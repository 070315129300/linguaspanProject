<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminAccountsSeeder extends Seeder
{
    public function run()
    {
        // Create a demo admin account
        User::updateOrCreate(
            ['email' => 'admin@linguaspan.com'],
            [
                'fullName' => 'Admin',
                'password' => Hash::make('adminpassword'), // Set your demo admin password
                'role' => 'admin', // Ensure you have a way to distinguish roles
            ]
        );

        // Create a demo user account
        User::updateOrCreate(
            ['email' => 'user@liguaspan.com'],
            [
                'FullName' => 'Cayleb User',
                'password' => Hash::make('userpassword'), // Set your demo user password
                'role' => 'user', // Ensure you have a way to distinguish roles
            ]
        );
    }
}
