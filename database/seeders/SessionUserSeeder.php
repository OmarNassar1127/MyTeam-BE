<?php

namespace Database\Seeders;

use App\Models\SessionUser;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SessionUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            SessionUser::create(['session_id' => 1, 'user_id' => 3, 'team_id' => 1, 'is_manager' => true,'is_absent' => false]);
            SessionUser::create(['session_id' => 1, 'user_id' => 5, 'team_id' => 1, 'is_manager' => false,'is_absent' => false]);
            SessionUser::create(['session_id' => 1, 'user_id' => 6, 'team_id' => 1, 'is_manager' => false,'is_absent' => false]);
            SessionUser::create(['session_id' => 2, 'user_id' => 4, 'team_id' => 2, 'is_manager' => true,'is_absent' => false]);
            SessionUser::create(['session_id' => 2, 'user_id' => 7, 'team_id' => 2, 'is_manager' => false,'is_absent' => false]);
            SessionUser::create(['session_id' => 2, 'user_id' => 8, 'team_id' => 2, 'is_manager' => false,'is_absent' => false]);
    }
}
