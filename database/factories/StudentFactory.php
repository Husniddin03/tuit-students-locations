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
            'faculty' => $this->faker->randomElement(['Kompyuter injiniring', 'Telekommunikatsiya texnologiyalari va kasb ta’limi']),
            'group' => $this->faker->bothify('??###'),
            'phone' => $this->faker->phoneNumber,
            'coach' => $this->faker->name,
            'father' => $this->faker->name('male'),
            'mather' => $this->faker->name('female'),
            'province' => $this->faker->randomElement(['Toshkent', 'Samarqand', 'Buxoro', 'Farg\'ona', 'Andijon', 'Namangan', 'Qashqadaryo', 'Surxondaryo', 'Jizzax', 'Sirdaryo', 'Xorazm', 'Navoiy', 'Qoraqalpog\'iston', 'Toshkent shahri']),
            'region' => $this->faker->randomElement(['Yunusobod', 'Chilonzor', 'Mirzo Ulug\'bek', 'Uchtepa', 'Olmazor', 'Shayxontohur', 'Bektemir', 'Mirobod', 'Sergeli', 'Yashnobod']),
            'latitude'=> $this->faker->latitude(),
            'longitude'=>$this->faker->longitude(),
            'address' => $this->faker->address,
            'map_home' => $this->faker->url(),
            'father_phone' => $this->faker->phoneNumber,
            'mather_phone' => $this->faker->phoneNumber,
        ];
    }
}
