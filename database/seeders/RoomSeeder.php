<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 11; $i++) {
            DB::table('rooms')->insert([
                'number_room' => $i,
                'facility' => '2 bed, ac, bathroom',
                'class' => 1,
                'capacity' => 2,
                'price' => 10000,
                'status' => 0, //0 free, 1 full, 2 booked
                'image_room' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        //
    }
}
