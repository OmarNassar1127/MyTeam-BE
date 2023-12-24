<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            UserRoleSeeder::class,
            ClubSeeder::class,
            TeamSeeder::class,
            PlayerProfileSeeder::class,
            SessionSeeder::class,
            GameSeeder::class,
            GameUserSeeder::class,
            TeamUserSeeder::class,
            SessionUserSeeder::class,
            PerformanceAnalysisSeeder::class,
            AdminSeeder::class,
        ]);
    }
}
