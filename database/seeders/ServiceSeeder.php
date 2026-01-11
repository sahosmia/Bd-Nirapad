<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Service::create(['name' => 'Service 1']);
        Service::create(['name' => 'Service 2']);
        Service::create(['name' => 'Service 3']);
    }
}
