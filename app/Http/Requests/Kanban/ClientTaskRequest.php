<?php

namespace App\Http\Requests\Kanban;

use App\Http\Requests\BaseRequest;

class ClientTaskRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'task_id' => ['required', 'integer', 'exists:tasks,id'],
            'client_id' => ['required', 'integer', 'exists:clients,id'],
        ];
    }
}
