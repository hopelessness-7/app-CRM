<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SchedulerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users'],
            'title' => ['required'],
            'label' => ['required'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date'],
            'all_day' => ['nullable', 'boolean'],
            'event_url' => ['nullable'],
            'location' => ['required'],
            'description' => ['required'],
        ];
    }
}
