<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Student;

class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition(): array
    {
        return [
            'student_id' => $this->faker->unique()->numberBetween(100000, 999999),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'middle_name' => $this->faker->optional()->firstName,
            'faculty' => $this->faker->word,
            'group' => $this->faker->bothify('??###'),
            'phone' => $this->faker->phoneNumber,
            'coach' => $this->faker->name,
            'father' => $this->faker->name('male'),
            'mather' => $this->faker->name('female'),
            'province' => $this->faker->state,
            'region' => $this->faker->city,
            'latitude'=> $this->faker->latitude(),
            'longitude'=>$this->faker->longitude(),
            'address' => $this->faker->address,
            'father_phone' => $this->faker->phoneNumber,
            'mather_phone' => $this->faker->phoneNumber,
        ];
    }
}
