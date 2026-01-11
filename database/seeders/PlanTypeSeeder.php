<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PlanType;

class PlanTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PlanType::create(['name' => 'Plan Type 1', 'company_id' => 1]);
        PlanType::create(['name' => 'Plan Type 2', 'company_id' => 1]);
        PlanType::create(['name' => 'Plan Type 3', 'company_id' => 2]);
    }
}
