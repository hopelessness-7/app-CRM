<?php

namespace Database\Factories\Chat;

use App\Models\Chat\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    public function definition(): array
    {
        $room = Room::inRandomOrder()->first();
        return [
            'room_id' => $room->id,
            'user_id' => $room->users()->inRandomOrder()->first()->id,
            'text' => $this->faker->text,
        ];
    }
}
