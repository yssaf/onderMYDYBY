<?php

use App\Certificates;
use Illuminate\Database\Seeder;

class CertificatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Certificates::insert([

               [
                   'certificate_id' => 2,
                   'title' => 'U',
                   'created_at' => '0000-00-00 00:00:00',
                   'updated_at' => '0000-00-00 00:00:00',
               ],
               [
                   'certificate_id' => 3,
                   'title' => 'PG',
                   'created_at' => '0000-00-00 00:00:00',
                   'updated_at' => '0000-00-00 00:00:00',
               ],
               [
                   'certificate_id' => 4,
                   'title' => '12',
                   'created_at' => '0000-00-00 00:00:00',
                   'updated_at' => '0000-00-00 00:00:00',
               ],
               [
                   'certificate_id' => 5,
                   'title' => '12A',
                   'created_at' => '0000-00-00 00:00:00',
                   'updated_at' => '0000-00-00 00:00:00',
               ],
               [
                   'certificate_id' => 6,
                   'title' => '15',
                   'created_at' => '0000-00-00 00:00:00',
                   'updated_at' => '0000-00-00 00:00:00',
               ],
               [
                   'certificate_id' => 7,
                   'title' => '18',
                   'created_at' => '0000-00-00 00:00:00',
                   'updated_at' => '0000-00-00 00:00:00',
               ]

        ]);
    }
}
