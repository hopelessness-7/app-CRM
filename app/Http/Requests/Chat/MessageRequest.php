<?php

namespace App\Http\Requests\Chat;

use App\Http\Requests\BaseRequest;

class MessageRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'room_id' => 'required|exists:rooms,id',
            'user_id' => 'required|exists:users,id',
            'text' => 'required|string|max:1000',
        ];
    }
}
