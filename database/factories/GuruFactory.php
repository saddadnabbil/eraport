<?php

namespace Database\Factories;

use App\Models\Karyawan;
use App\Models\Guru;
use Illuminate\Database\Eloquent\Factories\Factory;

class GuruFactory extends Factory
{
    protected $model = Guru::class;

    public function definition()
    {
        return [
            'karyawan_id' => Karyawan::factory()->create()->id,
        ];
    }
}
