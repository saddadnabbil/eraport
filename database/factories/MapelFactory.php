<?php

namespace Database\Factories;

use App\Models\Mapel;
use Illuminate\Database\Eloquent\Factories\Factory;

class MapelFactory extends Factory
{
    protected $model = Mapel::class;

    public function definition()
    {
        $namaMapel = $this->faker->unique()->randomElement([
            'Informatics', 'Mathematics', 'Indonesian Language', 'English Language', 'Science', 'Social Studies', 'Arts and Culture', 'Religious Education', 'agama-islam', 'Geography', 'History',
        ]);

        return [
            'tapel_id' => 1,
            'nama_mapel' => $namaMapel,
            'nama_mapel_indonesian' => $namaMapel,
            'ringkasan_mapel' => $namaMapel,
            'color' => $this->faker->hexColor(),
        ];
    }
}
