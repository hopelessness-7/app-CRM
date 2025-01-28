<?php

namespace App\Http\Requests\Chat;

use Illuminate\Foundation\Http\FormRequest;

class RoomUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['string', 'min:3', 'max:255'],

        ];
    }
}
