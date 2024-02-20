<?php

namespace Database\Factories;

use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'username' => $this->faker->userName,
            'password' => bcrypt('password'), // You should not store plain passwords, this is just for example
            'role' => $this->faker->randomElement(['2', '3']),
            'status' => true,
        ];
    }
}
