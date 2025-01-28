<?php

namespace App\Http\Requests\Client;

use App\Http\Requests\BaseRequest;

class ClientRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'contact_id' => ['required', 'exists:contacts'],
            'client_type_id' => ['required', 'integer'],
            'status' => ['required'],
            'notes' => ['required'],
            'worker_id' => ['required', 'integer'],
        ];
    }
}
