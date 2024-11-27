<?php

namespace App\Http\Resources\V1\Appointment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->whenNotNull($this->appointmentTitle) ,
            'meeting_link' => $this->whenNotNull($this->meeting_link) ,
        ];
    }
}
