<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class ClientUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'contact_id' => ['sometimes', 'exists:contacts,id'],
            'client_type_id' => ['sometimes', 'integer'],
            'worker_id' => ['required', 'integer', 'exists:workers,id'],
        ];
    }
}
