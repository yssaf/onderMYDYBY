<?php

use App\Formats;
use Illuminate\Database\Seeder;

class FormatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Formats::insert([
            [
                'format_id' => 1,
                'type' => 'DVD',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ],
            [
                'format_id' => 2,
                'type' => 'Blu-Ray',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ],
            [
                'format_id' => 3,
                'type' => 'Digital',
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ]
        ]);
    }
}
