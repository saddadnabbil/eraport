<?php

namespace Database\Factories;

use App\Models\AnggotaKelas;
use App\Models\Siswa;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnggotaKelasFactory extends Factory
{
    protected $model = AnggotaKelas::class;
    protected $siswaAlreadyAssigned = ['1', '2', '3'];

    public function definition()
    {
        // Ambil semua ID siswa yang belum di-assign ke kelas lain
        $siswaIds = Siswa::whereNotIn('id', $this->siswaAlreadyAssigned)->pluck('id')->toArray();

        // Ambil data siswa dengan ID acak
        $siswa = Siswa::find($this->faker->randomElement($siswaIds));

        // Tandai siswa sebagai sudah di-assign
        $this->siswaAlreadyAssigned[] = $siswa->id;

        return [
            'siswa_id' => $siswa->id,
            'kelas_id' => $siswa->kelas_id, // Gunakan kelas_id dari siswa
            'pendaftaran' => $this->faker->randomElement(['1', '2', '3', '4', '5']),
        ];
    }
}
