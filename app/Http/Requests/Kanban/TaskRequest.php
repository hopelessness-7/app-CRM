<?php

namespace App\Http\Requests\Kanban;

use App\Http\Requests\BaseRequest;

class TaskRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'description' => ['required'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date'],
            'hashtags' => ['required'],
            'dashboard_id' => ['required', 'exists:dashboards,id'],
        ];
    }
}
