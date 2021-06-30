<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('states')->insert([
            'country_id' => 1,
            'name' => 'Arizona',
            'code' => 'AZ'
        ]);
        
        DB::table('states')->insert([
            'country_id' => 1,
            'name' => 'California',
            'code' => 'CA'
        ]);
    }
}