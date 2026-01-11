<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::create(['name' => 'Company 1']);
        Company::create(['name' => 'Company 2']);
        Company::create(['name' => 'Company 3']);
    }
}
