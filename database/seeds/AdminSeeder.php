<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $userId = DB::table('users')->insertGetId([
            // 'id_user' => 1,
            'name' => 'admin',
            'email' => 'admin@reservation.com',
            'password' => '$2y$10$wNIDxA5tfzPm6XEsjrt0IOS9dbUrhjZSigPvzruq2Rz0BEqudStyK',
            'address' => '',
            'phone_number' => '',
            'gender' => '',
            'role' => 1 //1 untuk admin
        ]);

        $user = \App\User::find($userId);
        $user->assignRole('admin');
    }
}
