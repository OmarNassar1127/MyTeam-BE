<?php

namespace Database\Seeders;

use DB;
use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'id' => 1,
            'name' => 'Omar',
            'email' => 'omar@test.nl',
            'password' => Hash::make('test123'),
        ]);
    }
}