<?php

namespace Database\Factories;

use App\Models\Scheduler;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SchedulerFactory extends Factory
{
    protected $model = Scheduler::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'label' => Scheduler::LABEL_PERSONAL,
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now(),
            'all_day' => $this->faker->boolean(),
            'event_url' => $this->faker->url(),
            'location' => $this->faker->word(),
            'description' => $this->faker->text(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'deleted_at' => Carbon::now(),

            'user_id' => User::factory(),
        ];
    }
}
