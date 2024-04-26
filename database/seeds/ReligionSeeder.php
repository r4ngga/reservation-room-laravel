<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReligionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('religions')->insert([
            [
                'name' => 'Islam',
                'description' => '',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Kristen',
                'description' => '',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Katolik',
                'description' => '',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Hindu',
                'description' => '',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Budha',
                'description' => '',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Konghucu',
                'description' => '',
                'created_at' => Carbon::now(),
            ]
        ]);
    }
}
