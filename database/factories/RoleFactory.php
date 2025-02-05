<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition(): array
    {
        return [
            'name' => 'Super Admin',
            'slug' => 'super-admin',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
