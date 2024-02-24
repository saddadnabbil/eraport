<?php

namespace Database\Seeders;

use App\Models\JadwalPelajaranSlot;
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
            'start_time' => '07:30:00',
            'stop_time' => '08:15:00',
            'keterangan' => '1',
        ]);

        JadwalPelajaranSlot::create([
            'tapel_id' => 1,
            'start_time' => '08:15:00',
            'stop_time' => '09:00:00',
            'keterangan' => '1',
        ]);


        JadwalPelajaranSlot::create([
            'tapel_id' => 1,
            'start_time' => '09:00:00',
            'stop_time' => '09:30:00',
            'keterangan' => '2',
        ]);

        JadwalPelajaranSlot::create([
            'tapel_id' => 1,
            'start_time' => '09:30:00',
            'stop_time' => '10:15:00',
            'keterangan' => '1',
        ]);

        JadwalPelajaranSlot::create([
            'tapel_id' => 1,
            'start_time' => '10:15:00',
            'stop_time' => '11:00:00',
            'keterangan' => '1',
        ]);

        JadwalPelajaranSlot::create([
            'tapel_id' => 1,
            'start_time' => '11:00:00',
            'stop_time' => '11:45:00',
            'keterangan' => '1',
        ]);

        JadwalPelajaranSlot::create([
            'tapel_id' => 1,
            'start_time' => '11:45:00',
            'stop_time' => '12:30:00',
            'keterangan' => '1',
        ]);

        JadwalPelajaranSlot::create([
            'tapel_id' => 1,
            'start_time' => '12:30:00',
            'stop_time' => '13:15:00',
            'keterangan' => '3',
        ]);

        JadwalPelajaranSlot::create([
            'tapel_id' => 1,
            'start_time' => '13:15:00',
            'stop_time' => '14:00:00',
            'keterangan' => '1',
        ]);

        JadwalPelajaranSlot::create([
            'tapel_id' => 1,
            'start_time' => '14:00:00',
            'stop_time' => '14:45:00',
            'keterangan' => '1',
        ]);
    }
}
