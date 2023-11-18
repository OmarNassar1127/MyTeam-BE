<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Club;

class ClubSeeder extends Seeder
{
    public function run()
    {
        Club::create([
            'name' => 'Club One',
            'address' => '123 Main St',
            'contact_info' => '123-456-7890',
            'email' => 'clubone@example.com',
            'president_user_id' => 1,
        ]);

        Club::create([
            'name' => 'Club 2',
            'address' => '321 Main St',
            'contact_info' => '123-456-7890',
            'email' => 'club2@example.com',
            'president_user_id' => 2,
        ]);
    }
}
