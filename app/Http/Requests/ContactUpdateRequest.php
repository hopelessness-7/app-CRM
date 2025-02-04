<?php

namespace App\Http\Requests;


class ContactUpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'surname' => 'string|min:3',
            'first_name' => 'string|min:3',
            'patronymic' => 'string|min:3',
            'date_birth' => 'date',
            'address' => 'string|min:5',
            'place_work' => 'string|min:3',
            'job_position' => 'string|min:3',
        ];
    }
}
