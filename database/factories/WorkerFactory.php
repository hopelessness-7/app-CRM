<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\User;
use App\Models\Worker;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkerFactory extends Factory
{
    protected $model = Worker::class;

    public function definition(): array
    {
        return [

            'company_id' => Company::factory(),
            'user_id' => User::factory(),
        ];
    }
}
