<?php

namespace Database\Factories;

use App\AnggotaKelas;
use Database\Factories\SiswaFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

    class AnggotaKelasFactory extends Factory
    {
        /**
         * Define the model's default state.
         *
         * @return array
         */
        public function definition()
        {
            // Get a new instance of Siswa using the factory
            $siswa = SiswaFactory::new()->make();

            // Use a loop to ensure uniqueness
            $siswaId = null;
            do {
                $siswaId = $siswa->user_id; // Use the user_id as siswa_id
            } while (AnggotaKelas::where('siswa_id', $siswaId)->exists());

            $kelasId = $this->faker->numberBetween(1, 2);

            return [
                'siswa_id' => $siswaId,
                'kelas_id' => $kelasId,
                'pendaftaran' => 1
            ];
        }
    }
