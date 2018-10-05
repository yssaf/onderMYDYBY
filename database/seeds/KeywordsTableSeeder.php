<?php

use App\Keywords;
use Illuminate\Database\Seeder;

class KeywordsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Keywords::insert([

                [
                    'keyword_id' => 1,
                    'word' => 'Aliens',
                    'created_at' => '2016-02-01 16:49:40',
                    'updated_at' => '2016-02-01 16:49:40',
                ],

                [
                    'keyword_id' => 2,
                    'word' => 'Dragon',
                    'created_at' => '2016-02-01 16:49:40',
                    'updated_at' => '2016-02-01 16:49:40',
                ],

                [
                    'keyword_id' => 3,
                    'word' => 'Magic',
                    'created_at' => '2016-02-01 16:49:40',
                    'updated_at' => '2016-02-01 16:49:40',
                ],

                [
                    'keyword_id' => 4,
                    'word' => 'MCU',
                    'created_at' => '2016-02-01 16:49:40',
                    'updated_at' => '2016-02-01 16:49:40',
                ],

                [
                    'keyword_id' => 5,
                    'word' => 'Bond',
                    'created_at' => '2016-02-01 16:49:40',
                    'updated_at' => '2016-02-01 16:49:40',
                ],

                [
                    'keyword_id' => 6,
                    'word' => 'TV',
                    'created_at' => '2016-02-20 14:02:00',
                    'updated_at' => '2016-02-20 14:02:00',
                ],

                [
                    'keyword_id' => 7,
                    'word' => 'Laurel',
                    'created_at' => '2016-02-21 15:37:30',
                    'updated_at' => '2016-02-21 15:37:30',
                ],

                [
                    'keyword_id' => 8,
                    'word' => 'Hardy',
                    'created_at' => '2016-02-21 15:37:36',
                    'updated_at' => '2016-02-21 15:37:36',
                ],
        ]);
    }
}
