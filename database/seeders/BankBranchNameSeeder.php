<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BankBranchName;

class BankBranchNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BankBranchName::create(['name' => 'Branch 1', 'bank_district_id' => 1]);
        BankBranchName::create(['name' => 'Branch 2', 'bank_district_id' => 1]);
        BankBranchName::create(['name' => 'Branch 3', 'bank_district_id' => 2]);
    }
}
