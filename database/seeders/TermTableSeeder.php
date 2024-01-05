<?php

namespace Database\Seeders;

use App\Term;
use App\Tapel;
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
    }
}
