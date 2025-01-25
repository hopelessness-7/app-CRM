<?php

namespace App\Http\Requests\Kanban;

use App\Http\Requests\BaseRequest;

class TaskUpdateRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string'], // Поле передается, только если оно есть в запросе
            'description' => ['sometimes', 'string'],
            'start_date' => ['sometimes', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'], // Дата окончания должна быть >= дате начала
            'hashtags' => ['sometimes', 'array'],
            'hashtags.*' => ['string'], // Проверка каждого элемента массива
            'dashboard_id' => ['sometimes', 'exists:dashboards,id'], // Указание таблицы и поля
        ];
    }
}
