<?php

namespace App\Http\Resources;

use App\Models\Scheduler;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Scheduler */
class SchedulerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'label' => $this->lable,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'all_day' => $this->all_day,
            'event_url' => $this->event_url,
            'location' => $this->location,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
