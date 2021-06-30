<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cities')->insert([
            'country_id' => 1,
            'state_id' => 1,
            'name' => 'Phoenix',
            'code' => 'PH'
        ]);

        DB::table('cities')->insert([
            'country_id' => 1,
            'state_id' => 2,
            'name' => 'San Jose',
            'code' => 'SA'
        ]);
    }
}