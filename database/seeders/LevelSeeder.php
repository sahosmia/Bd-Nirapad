<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Level;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Level::create(['title' => 'Level 1']);
        Level::create(['title' => 'Level 2']);
        Level::create(['title' => 'Level 3']);
    }
}
