<?php

namespace Database\Seeders;

use App\Models\TeamUser;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TeamUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            TeamUser::create(['team_id' => 1, 'user_id' => 3, 'is_manager' => true]);
            TeamUser::create(['team_id' => 1, 'user_id' => 5, 'is_manager' => false]);
            TeamUser::create(['team_id' => 1, 'user_id' => 6, 'is_manager' => false]);
            TeamUser::create(['team_id' => 2, 'user_id' => 4, 'is_manager' => true]);
            TeamUser::create(['team_id' => 2, 'user_id' => 7, 'is_manager' => false]);
            TeamUser::create(['team_id' => 2, 'user_id' => 8, 'is_manager' => false]);
    }
}
