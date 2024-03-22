<?php

namespace Database\Seeders;

use App\Models\TkEvent;
use Illuminate\Database\Seeder;

class TkEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TkEvent::create([
            'tapel_id' => 1,
            'name' => 'Event 1',
        ]);

        TkEvent::create([
            'tapel_id' => 1,
            'name' => 'Event 2',
        ]);

        TkEvent::create([
            'tapel_id' => 1,
            'name' => 'Event 3',
        ]);

        TkEvent::create([
            'tapel_id' => 1,
            'name' => 'Event 4',
        ]);
    }
}
