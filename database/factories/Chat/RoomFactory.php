<?php

namespace Database\Factories\Chat;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'type' => 'private',
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function ($room) {
            // Привязываем случайных пользователей к комнате через связь many-to-many
            $users = User::inRandomOrder()->take(2)->pluck('id'); // Случайные пользователи
            $room->users()->attach($users); // Привязываем пользователей
        });
    }
}
