<?php

namespace Database\Factories;

use App\Models\CommunicationType;
use App\Models\Contact;
use App\Models\ContactInformation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactInformationFactory extends Factory
{
    protected $model = ContactInformation::class;

    public function definition(): array
    {
        return [
            'contact_id' => Contact::factory(),
            'communication_type_id' => CommunicationType::factory(),
            'value' => CommunicationType::$getTypes[$this->faker->numberBetween(0, 8)],
        ];
    }
}
