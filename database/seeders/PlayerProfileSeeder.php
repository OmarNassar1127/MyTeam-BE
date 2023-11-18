<?php

namespace Database\Seeders;

use App\Models\PlayerProfile;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PlayerProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PlayerProfile::create(['user_id' => 5, 'team_id' => 1, 'position' => 'defender']);
        PlayerProfile::create(['user_id' => 6, 'team_id' => 1, 'position' => 'keeper']);
        PlayerProfile::create(['user_id' => 7, 'team_id' => 2, 'position' => 'defender']);
        PlayerProfile::create(['user_id' => 8, 'team_id' => 2, 'position' => 'keeper']);
    }
}
