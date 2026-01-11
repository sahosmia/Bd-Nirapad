<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Plan::create(['name' => 'Plan 1', 'plan_type_id' => 1]);
        Plan::create(['name' => 'Plan 2', 'plan_type_id' => 1]);
        Plan::create(['name' => 'Plan 3', 'plan_type_id' => 2]);
    }
}
