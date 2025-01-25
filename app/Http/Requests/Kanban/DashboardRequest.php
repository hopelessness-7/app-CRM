<?php

namespace App\Http\Requests\Kanban;

use App\Http\Requests\BaseRequest;

class DashboardRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'description' => 'required|string',
            'banner' => 'image',
            'team_id' => 'required|exists:teams,id'
        ];
    }
}
