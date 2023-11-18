<?php

namespace Database\Seeders;

use App\Models\Game;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            Game::create(['team_id' => 1, 'date' => '2023-11-14 14:58:21', 'opponent' => 'Real Madrid', 'season' => '2023/2034']);
            Game::create(['team_id' => 2, 'date' => '2023-11-14 14:58:21', 'opponent' => 'FC Barcelona', 'season' => '2023/2024']);
    }
}
