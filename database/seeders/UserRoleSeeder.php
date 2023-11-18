<?php

namespace Database\Seeders;

use App\Models\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            UserRole::create(['user_id' => 1, 'role_id' => 1]);
            UserRole::create(['user_id' => 2, 'role_id' => 1]);
            UserRole::create(['user_id' => 3, 'role_id' => 2]);
            UserRole::create(['user_id' => 4, 'role_id' => 2]);
            UserRole::create(['user_id' => 5, 'role_id' => 3]);
            UserRole::create(['user_id' => 6, 'role_id' => 3]);
            UserRole::create(['user_id' => 7, 'role_id' => 3]);
            UserRole::create(['user_id' => 8, 'role_id' => 3]);

    }
}
