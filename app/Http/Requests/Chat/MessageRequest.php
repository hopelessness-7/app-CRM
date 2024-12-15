<?php

namespace App\Http\Requests\Chat;

use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'room_id' => 'required|exists:rooms,id',
            'user_id' => 'required|exists:users,id',
            'text' => 'required|string|max:1000',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
