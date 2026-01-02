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
            'password' => bcrypt('password'),
            'address' => '',
            'phone_number' => '',
            'gender' => '',
        ]);

        $user = \App\User::find($userId);
        $user->assignRole('admin');
    }
}
