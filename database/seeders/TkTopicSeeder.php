<?php

namespace Database\Seeders;

use App\Models\TkTopic;
use Illuminate\Database\Seeder;

class TkTopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        function randomColor()
        {
            return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
        }

        TkTopic::create([
            'tk_element_id' => 1,
            'name' => 'ENGLISH LANGUAGE',
            'color' => randomColor(),
        ]);
        TkTopic::create([
            'tk_element_id' => 1,
            'name' => 'ENGLISH LITERACY',
            'color' => randomColor(),
        ]);
        TkTopic::create([
            'tk_element_id' => 1,
            'name' => 'BAHASA INDONESIA',
            'color' => randomColor(),
        ]);

        TkTopic::create([
            'tk_element_id' => 2,
            'name' => 'NUMERACY',
            'color' => randomColor(),
        ]);

        TkTopic::create([
            'tk_element_id' => 3,
            'name' => 'SCIENCE',
            'color' => randomColor(),
        ]);

        TkTopic::create([
            'tk_element_id' => 4,
            'name' => 'SCIENCE',
            'color' => randomColor(),
        ]);
    }
}
