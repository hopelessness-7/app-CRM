<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class ClientUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'contact_id' => ['sometimes', 'exists:contacts,id'],
            'client_type_id' => ['sometimes', 'integer', 'exists:client_types,id'],
            'status' => ['string'],
            'notes' => ['string'],
        ];
    }
}
