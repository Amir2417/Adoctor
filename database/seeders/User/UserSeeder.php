<?php

namespace Database\Seeders\User;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'firstname'         => "Test",
                'lastname'          => "User",
                'email'             => "user@appdevs.net",
                'username'          => "testuser",
                'status'            => true,
                'password'          => Hash::make("appdevs"),
                'email_verified'    => true,
                'sms_verified'      => true,
                'created_at'        => now(),
            ],
            [
                'firstname'         => "Test",
                'lastname'          => "User",
                'email'             => "user1@appdevs.net",
                'username'          => "testuser1",
                'status'            => false,
                'password'          => Hash::make("appdevs"),
                'email_verified'    => false,
                'sms_verified'      => false,
                'created_at'        => now(),
            ],
        ];

        User::insert($data);
    }
}
