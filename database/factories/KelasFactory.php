<?php

namespace Database\Factories;

use App\Kelas;
use App\Guru;
use Illuminate\Database\Eloquent\Factories\Factory;

class KelasFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Kelas::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        static $tingkatanCounts = [];
        $tingkatanId = $this->faker->randomElement([1, 2, 3, 4, 5]);

        if (!isset($tingkatanCounts[$tingkatanId])) {
            $tingkatanCounts[$tingkatanId] = 1;
        }

        $jurusanId = $tingkatanId == 5 ? $this->faker->randomElement([1, 2]) : 3;
        $tapelId = 1; // Assuming tapel_id is always 1
        $guruId = Guru::factory()->create()->id;

        $prefix = '';
        switch ($tingkatanId) {
            case 1:
                $prefix = 'PA';
                break;
            case 2:
                $prefix = 'KG';
                break;
            case 3:
                $prefix = 'PS';
                break;
            case 4:
                $prefix = 'JHS';
                break;
            case 5:
                $prefix = 'SHS';
                break;
        }

        $namaKelas = $prefix . $tingkatanCounts[$tingkatanId]++;
        return [
            'tingkatan_id' => $tingkatanId,
            'jurusan_id' => $jurusanId,
            'tapel_id' => $tapelId,
            'guru_id' => $guruId,
            'nama_kelas' => $namaKelas,
        ];
    }
}
