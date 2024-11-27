<?php

namespace App\Http\Resources\V1\Appointment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAppointmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'date' => $this->whenNotNull($this->dateFormat) ,
            'hour' => $this->whenNotNull($this->hourFormat) ,
            'title' => $this->whenNotNull($this->title) ,
        ];
    }
}
