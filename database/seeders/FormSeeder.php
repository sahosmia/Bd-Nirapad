<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Form;

class FormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Form::create(['name' => 'Form 1']);
        Form::create(['name' => 'Form 2']);
        Form::create(['name' => 'Form 3']);
    }
}
