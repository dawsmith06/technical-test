<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Darwin rosso',
            'email' => 'admin@admin.com',
            'password' => \Hash::make('12345678'),
            'identification_card' => '40224605143',
            'birth_date' => '1996-06-05',
            'city_id' => 1
        ]);
    }
}
