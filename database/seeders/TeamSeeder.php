<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team;

class TeamSeeder extends Seeder
{
    public function run()
    {
        // Assuming club IDs are 1 and 2
        Team::create([
            'club_id' => 1,
            'name' => 'Team A1',
            'category' => 'Category1',
        ]);

        Team::create([
            'club_id' => 2,
            'name' => 'Team A1',
            'category' => 'Category3',
        ]);
    }
}
