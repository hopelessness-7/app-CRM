<?php

namespace Database\Factories;

use App\Models\CommunicationType;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommunicationTypeFactory extends Factory
{
    protected $model = CommunicationType::class;

    public function definition(): array
    {
        return [
            'type' => CommunicationType::$getTypes[$this->faker->numberBetween(0, 8)],
        ];
    }
}
