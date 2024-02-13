<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class JadwalPelajaranFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id'        => $this->faker->numberBetween(1, 10000),
            'tapel_id'  => 1,
            'kelas_id'  => 1,
        ];
    }
}
