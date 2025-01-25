<?php

namespace App\Http\Requests\Kanban;

use App\Http\Requests\BaseRequest;

class TeamUpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'string',
            'description' => 'string',
            'banner' => 'image',
        ];
    }
}
