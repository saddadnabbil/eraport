<?php

use Database\Seeders\TapelTableSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            TapelTableSeeder::class,
            UsersTableSeeder::class,
            SekolahTableSeeder::class,
            // Add other seeders if needed
        ]);
    }
}
