<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Deal;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class DealFactory extends Factory
{
    protected $model = Deal::class;

    public function definition(): array
    {
        return array(
            'title' => $this->faker->word(),
            'description' => $this->faker->text(),
            'status' => Deal::$statuses[rand(0, 5)],
            'amount' => 321,
            'stage' => Deal::$stages[rand(0, 5)],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'client_id' => Client::factory(),
        );
    }
}
