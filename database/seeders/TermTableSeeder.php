<?php

namespace Database\Seeders;

use App\Models\Term;
use App\Models\Tapel;
use Illuminate\Database\Seeder;

class TermTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Term::create([
            'term' => 1,
        ]);

        Term::create([
            'term' => 2,
        ]);

        Term::create([
            'term' => 3,
        ]);

        Term::create([
            'term' => 4,
        ]);
    }
}
