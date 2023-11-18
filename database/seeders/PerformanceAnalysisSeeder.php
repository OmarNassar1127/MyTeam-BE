<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PerformanceAnalysis;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PerformanceAnalysisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PerformanceAnalysis::create([
            'game_id' => null,
            'session_id' => 1,
            'player_profile_id' => 1,
            'metrics' => json_encode(['distance' => 10, 'passes' => 5])
        ]);

        PerformanceAnalysis::create([
            'game_id' => null,
            'session_id' => 2,
            'player_profile_id' => 3,
            'metrics' => json_encode(['distance' => 15, 'passes' => 10])
        ]);
    }
}
