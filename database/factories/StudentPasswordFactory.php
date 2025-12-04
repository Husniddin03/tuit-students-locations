<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\StudentPassword;

class StudentPasswordFactory extends Factory
{
    protected $model = StudentPassword::class;

    public function definition(): array
    {
        return [
            'student_id' => $this->faker->unique()->numberBetween(100000, 999999),
            'password' => $this->faker->word(),
        ];
    }
}
