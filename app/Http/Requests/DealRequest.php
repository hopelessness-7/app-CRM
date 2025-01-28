<?php

namespace App\Http\Requests;

use App\Models\Deal;
use Illuminate\Validation\Rule;

class DealRequest extends BaseRequest
{
    public function rules(): array
    {
        $rules = [
            'client_id' => ['required', 'exists:clients,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
            'status' => ['required', Rule::in(Deal::$statuses)],
            'amount' => ['required', 'numeric', 'min:0'],
            'stage' => ['required', Rule::in(Deal::$stages)],
        ];

        if ($this->isMethod('patch') || $this->isMethod('put')) {
            // Изменения для PUT/PATCH запросов (обновление)
            $rules['client_id'] = ['sometimes', 'exists:clients,id'];
            $rules['title'] = ['sometimes', 'string', 'max:255'];
            $rules['status'] = ['sometimes', Rule::in(Deal::$statuses)];
            $rules['amount'] = ['sometimes', 'numeric', 'min:0'];
            $rules['stage'] = ['sometimes', Rule::in(Deal::$stages)];
        }

        return $rules;
    }
}
