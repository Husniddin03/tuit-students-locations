<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Rent;

class RentFactory extends Factory
{
    protected $model = Rent::class;

    public function definition(): array
    {
        return [
            'province' => $this->faker->state,
            'region' => $this->faker->city,
            'address' => $this->faker->address,
            'owner_name' => $this->faker->name,
            'owner_phone' => $this->faker->phoneNumber,
            'category' => $this->faker->word,
            'type' => $this->faker->word,
            'latitude'=> $this->faker->latitude(),
            'longitude'=>$this->faker->longitude(),
            'contract' => $this->faker->randomFloat(2, 1000, 5000),
            'amount' => $this->faker->randomFloat(2, 100, 500),
        ];
    }
}
