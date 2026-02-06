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
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@reservation.com'],
            [
                'name' => 'admin',
                'password' => bcrypt('password'),
                'address' => '',
                'phone_number' => '',
                'gender' => '',
                'role' => 1,
            ]
        );

        $user = \App\User::where('email', 'admin@reservation.com')->first();
        $user->assignRole('admin');
    }
}
