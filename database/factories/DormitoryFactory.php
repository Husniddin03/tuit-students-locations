<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Dormitory;

class DormitoryFactory extends Factory
{
    protected $model = Dormitory::class;

    public function definition(): array
    {
        return [
            'dormitory' => $this->faker->numberBetween(1, 10).' - sonli',
            'room' => $this->faker->numberBetween(100, 500),
            'privileged' => $this->faker->randomFloat(2, 0, 50),
            'amount' => $this->faker->randomFloat(2, 100, 500),
        ];
    }
}
