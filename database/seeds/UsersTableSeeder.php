<?php

use App\User;
use Illuminate\Database\Seeder;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create([
            'role_id'=>1,
            'active'=>1,
            'name'=>'yusuf',
            'email'=>'hajjar@gmail.com',
            'password'=>bcrypt('yusuf123'),
            'level'=>1,
            'remember_token'=>str_random(10),
        ]);
    }
}
