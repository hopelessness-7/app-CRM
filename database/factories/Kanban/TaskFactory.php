<?php

namespace Database\Factories\Kanban;

use App\Models\Kanban\Dashboard;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-1 year', 'now');
        $endDate = $this->faker->dateTimeBetween($startDate, '+1 year');

        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'hashtags' => ['test', 'feature_test'],
            'dashboard_id' => Dashboard::factory()->create()->id,
        ];
    }
}
