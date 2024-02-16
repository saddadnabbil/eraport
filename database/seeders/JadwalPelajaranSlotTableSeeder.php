<?php

namespace Database\Seeders;

use App\JadwalPelajaranSlot;
use Illuminate\Database\Seeder;

class JadwalPelajaranSlotTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $table->time('start_time');
        // $table->time('stop_time');
        // $table->enum('keterangan', ['1', '2', '3']);
        JadwalPelajaranSlot::create([
            'tapel_id' => 1,
            'start_time' => '08:00:00',
            'stop_time' => '10:00:00',
            'keterangan' => '1',
        ]);

        JadwalPelajaranSlot::create([
            'tapel_id' => 1,
            'start_time' => '10:00:00',
            'stop_time' => '11:00:00',
            'keterangan' => '3',
        ]);
    }
}
