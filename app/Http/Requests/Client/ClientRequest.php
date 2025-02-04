<?php

namespace App\Http\Requests\Client;

use App\Http\Requests\BaseRequest;

class ClientRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'contact_id' => ['required', 'exists:contacts,id'],
            'client_type_id' => ['required', 'integer', 'exists:client_types,id'],
            'status' => ['required', 'string'],
            'notes' => ['required', 'string'],
            'worker_id' => ['required', 'integer', 'exists:workers,id'],
        ];
    }
}
