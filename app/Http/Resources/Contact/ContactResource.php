<?php

namespace App\Http\Resources\Contact;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'surname' => $this->surname,
            'first_name' => $this->first_name,
            'patronymic' => $this->patronymic,
            'date_birth' => $this->date_birth,
            'address' => $this->address,
            'place_work' => $this->place_work,
            'job_position' => $this->job_position,
        ];
    }
}
