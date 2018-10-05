<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Role::insert([
            ['name'=>'admin'],
            ['name'=>'Receptionist'],
            ['name'=>'Manager'],
            ['name'=>'CEO']
        ]);
    }
}
