<?php

namespace App\Http\Requests;

use App\Models\Scheduler;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SchedulerRequest extends BaseRequest
{
    public function rules(): array
    {
        $rules = [
            'user_id' => ['required', 'exists:users,id'],
            'title' => ['required', 'string', 'max:100'],
            'label' => ['required', Rule::in(Scheduler::$labels)],
            'start_date' => ['nullable', 'date', 'required_if:all_day,null'],
            'end_date' => ['nullable', 'date', 'required_if:start_date,!=,null', 'after_or_equal:start_date'],
            'all_day' => ['nullable', 'boolean', 'required_if:start_date,null'],
            'event_url' => ['string'],
            'location' => ['string'],
            'description' => ['string', 'max:250'],
        ];

        if ($this->isMethod('patch') || $this->isMethod('put')) {
            // Изменения для PUT/PATCH запросов (обновление)
            $rules['user_id'] = ['sometimes', 'exists:users,id'];
            $rules['title'] = ['sometimes', 'string', 'max:100'];
            $rules['label'] = ['sometimes', Rule::in(Scheduler::$labels)];
            $rules['start_date'] = ['date'];
            $rules['end_date'] = ['nullable', 'date', 'required_if:start_date,!=,null', 'after_or_equal:start_date'];
            $rules['all_day'] = ['nullable', 'boolean'];
            $rules['event_url'] = ['string'];
            $rules['location'] = ['string'];
            $rules['description'] = ['string', 'max:250'];
        }

        return $rules;
    }
}
