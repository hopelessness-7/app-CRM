<?php

namespace App\Http\Requests\Chat;

use App\Http\Requests\BaseRequest;

class MessageUpdateRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'text' => 'required|string|max:1000',
        ];
    }
}
