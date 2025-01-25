<?php

namespace App\Http\Resources;

use App\Models\Deal;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Deal */
class DealResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'amount' => $this->amount,
            'stage' => $this->stage,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
