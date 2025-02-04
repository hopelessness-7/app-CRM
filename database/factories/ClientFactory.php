<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\ClientType;
use App\Models\Contact;
use App\Models\Worker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition(): array
    {
        return [
            'client_type_id' => ClientType::factory()->create()->id,
            'status' => $this->faker->word(),
            'notes' => $this->faker->word(),
            'worker_id' => Worker::factory()->create()->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'contact_id' => Contact::factory()->create()->id,
        ];
    }
}
