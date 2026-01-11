<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BankDistrict;

class BankDistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BankDistrict::create(['name' => 'District 1', 'bank_id' => 1]);
        BankDistrict::create(['name' => 'District 2', 'bank_id' => 1]);
        BankDistrict::create(['name' => 'District 3', 'bank_id' => 2]);
    }
}
