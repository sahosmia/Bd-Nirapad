<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Operator;

class OperatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Operator::create(['name' => 'Operator 1']);
        Operator::create(['name' => 'Operator 2']);
        Operator::create(['name' => 'Operator 3']);
    }
}
