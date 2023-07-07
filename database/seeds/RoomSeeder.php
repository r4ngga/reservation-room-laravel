<?php

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
        DB::table('rooms')->insert([
            'number_room' => 1,
            'facility' => '2 bed, ac, bathroom',
            'class' => 'Reguler',
            'capacity' => 2,
            'price' => 10000,
            'status' => 'free',
            'image_room' => null,
        ]);
        //
    }
}
