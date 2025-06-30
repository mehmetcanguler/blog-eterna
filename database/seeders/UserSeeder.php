<?php

namespace Database\Seeders;

use App\Enums\LoginType;
use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@blog.com',
            'password' => 'password',
            'login_type' => LoginType::EMAIL,
            'email_verified_at' => now(),
        ]);

        $admin->assignRole(RoleEnum::ADMIN->value);
    }
}
