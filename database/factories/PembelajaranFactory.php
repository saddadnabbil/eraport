<?php

namespace Database\Factories;

use App\Models\Pembelajaran;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Guru;
use Illuminate\Database\Eloquent\Factories\Factory;

class PembelajaranFactory extends Factory
{
    protected $model = Pembelajaran::class;

    public function definition()
    {
        $kelas = Kelas::inRandomOrder()->first();
        $mapel = Mapel::inRandomOrder()->first();
        $guru = Guru::inRandomOrder()->first();

        return [
            'kelas_id' => $kelas->id,
            'mapel_id' => $mapel->id,
            'guru_id' => $guru->id,
            'status' => true
        ];
    }
}
