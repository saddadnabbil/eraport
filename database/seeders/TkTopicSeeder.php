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
        TkTopic::create([
            'tk_element_id' => 1,
            'name' => 'ENGLISH LANGUAGE',
        ]);
        TkTopic::create([
            'tk_element_id' => 1,
            'name' => 'ENGLISH LITERACY',
        ]);
        TkTopic::create([
            'tk_element_id' => 1,
            'name' => 'BAHASA INDONESIA',
        ]);

        TkTopic::create([
            'tk_element_id' => 2,
            'name' => 'NUMERACY',
        ]);

        TkTopic::create([
            'tk_element_id' => 3,
            'name' => 'SCIENCE',
        ]);

        TkTopic::create([
            'tk_element_id' => 4,
            'name' => 'SCIENCE',
        ]);
    }
}
