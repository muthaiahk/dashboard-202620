<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Carbon;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'mobile_number' => '9876543210',
            'otp' => '123456',
            'otp_expires_at' => Carbon::now()->addMinutes(10),
            'role_id' => 1,
            'status' => 1,
            'address' => 'Madurai',
            'avatar' => null,
        ]);
    }
}