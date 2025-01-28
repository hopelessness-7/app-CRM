<?php

namespace App\Http\Resources\Kanban;

use App\Models\Kanban\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Task */
class TaskResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'hashtags' => $this->hashtags,

            'dashboard' => [
                'id' => $this->dashboard->id,
                'title' => $this->dashboard->title,
                'team' => [
                    'id' => $this->dashboard->team->id,
                    'name' => $this->dashboard->team->name,
                ],
            ],
        ];
    }
}
