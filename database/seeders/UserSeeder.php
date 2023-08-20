<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password = 'Test123@';
        $user = [
            [
                'id' => 'e53163a3-c2e8-42be-9e98-e4b8d18c8c03',
                'email' => 'rifaldimahsyaf@gmail.com',
                'password' => Hash::make($password),
                'is_active' => 1,
            ],
            [
                'id' => '7792b359-2ccb-49ca-bf0e-7a635829433a',
                'email' => 'admin@gmail.com',
                'password' => Hash::make($password),
                'is_active' => 1,
            ]
        ];

        User::insert($user);
    }
}
