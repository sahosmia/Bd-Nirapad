<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bank;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bank::create(['name' => 'Bank 1']);
        Bank::create(['name' => 'Bank 2']);
        Bank::create(['name' => 'Bank 3']);
    }
}
