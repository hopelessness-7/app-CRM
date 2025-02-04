<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'surname' => $this->faker->lastName(),
            'first_name' => $this->faker->firstName(),
            'patronymic' => $this->faker->lastName(),
            'date_birth' => $this->faker->date(),
            'address' => $this->faker->address(),
            'place_work' => $this->faker->company(),
            'job_position' => $this->faker->jobTitle(),
        ];
    }
}
