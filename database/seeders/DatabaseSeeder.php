<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(BankSeeder::class);
        $this->call(BankDistrictSeeder::class);
        $this->call(BankBranchNameSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(FormSeeder::class);
        $this->call(LevelSeeder::class);
        $this->call(OperatorSeeder::class);
        $this->call(PlanTypeSeeder::class);
        $this->call(PlanSeeder::class);
        $this->call(ServiceSeeder::class);
    }
}
