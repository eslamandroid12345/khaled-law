<?php

namespace App\Http\Resources\V1\Consultation;

use App\Repository\InfoRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConsultationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
                    'id' => $this->id,
                    'image' => url(app(InfoRepositoryInterface::class)->getValue('image_consultation')),
                    'type' => __('dashboard.consultation').$this->type_value,
                    'subject' => __('messages.consultations_for : ').$this->subject,
                    'lawyer_name' => $this->lawyer?->name,
                    'lawyer_image' => $this->lawyer?->image,
                    'date' => $this->formatted_date,
                    'time' => $this->formatted_time,
                ];
    }
}
