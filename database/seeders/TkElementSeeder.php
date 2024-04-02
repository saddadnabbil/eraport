<?php

namespace Database\Seeders;

use App\Models\TkElement;
use Illuminate\Database\Seeder;

class TkElementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TkElement::create([
            'tingkatan_id' => 1,
            'name' => 'COMMUNICATION, LANGUAGES AND LITERACY',
        ]);
        TkElement::create([
            'tingkatan_id' => 1,
            'name' => 'PROBLEM SOLVING, REASONING AND NUMERACY',
        ]);
        TkElement::create([
            'tingkatan_id' => 1,
            'name' => 'KNOWLEDGE AND UNDERSTANDING OF THE WORLD',
        ]);
    }
}
