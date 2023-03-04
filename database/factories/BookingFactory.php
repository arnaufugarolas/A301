<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    public function definition(): array
    {
        return [
            'start_date' => $this->faker->date(),
            'start_time' => $this->faker->time(),
            'end_date' => $this->faker->date(),
            'end_time' => $this->faker->time(),
            'user_id' => User::all()->random()->id,
        ];
    }
}
