<?php

namespace Database\Seeders;

use App\Models\Session;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            Session::create(['team_id' => 1, 'date' => '2023-11-14 14:58:21', 'notes' => 'notes', 'completed' => true]);
            Session::create(['team_id' => 2, 'date' => '2023-11-14 14:58:21', 'notes' => 'notes', 'completed' => true]);
    }
}
