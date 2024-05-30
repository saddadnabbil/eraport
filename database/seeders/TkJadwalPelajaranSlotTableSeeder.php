<?php

namespace Database\Seeders;

use App\Models\TkJadwalPelajaranSlot;
use Illuminate\Database\Seeder;

class TkJadwalPelajaranSlotTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TkJadwalPelajaranSlot::create([
            'tapel_id' => 1,
            'start_time' => '08:00:00',
            'stop_time' => '08:30:00',
            'keterangan' => '1',
        ]);

        TkJadwalPelajaranSlot::create([
            'tapel_id' => 1,
            'start_time' => '08:30:00',
            'stop_time' => '09:00:00',
            'keterangan' => '1',
        ]);

        TkJadwalPelajaranSlot::create([
            'tapel_id' => 1,
            'start_time' => '09:00:00',
            'stop_time' => '09:30:00',
            'keterangan' => '1',
        ]);

        TkJadwalPelajaranSlot::create([
            'tapel_id' => 1,
            'start_time' => '09:30:00',
            'stop_time' => '09:45:00',
            'keterangan' => '1',
        ]);

        TkJadwalPelajaranSlot::create([
            'tapel_id' => 1,
            'start_time' => '09:45:00',
            'stop_time' => '10:15:00',
            'keterangan' => '1',
        ]);

        TkJadwalPelajaranSlot::create([
            'tapel_id' => 1,
            'start_time' => '10:15:00',
            'stop_time' => '10:45:00',
            'keterangan' => '1',
        ]);

        TkJadwalPelajaranSlot::create([
            'tapel_id' => 1,
            'start_time' => '10:45:00',
            'stop_time' => '11:15:00',
            'keterangan' => '3',
        ]);

        TkJadwalPelajaranSlot::create([
            'tapel_id' => 1,
            'start_time' => '11:15:00',
            'stop_time' => '11:45:00',
            'keterangan' => '1',
        ]);

        TkJadwalPelajaranSlot::create([
            'tapel_id' => 1,
            'start_time' => '11:45:00',
            'stop_time' => '12:15:00',
            'keterangan' => '1',
        ]);
        TkJadwalPelajaranSlot::create([
            'tapel_id' => 1,
            'start_time' => '12:15:00',
            'stop_time' => '12:30:00',
            'keterangan' => '2',
        ]);
    }
}
