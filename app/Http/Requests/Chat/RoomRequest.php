<?php

namespace App\Http\Requests\Chat;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'type' => ['required'],
            'user_form_id' => ['required', 'exists:users,id'],
            'user_to_id' => ['required', 'exists:users,id'],
        ];
    }
}
