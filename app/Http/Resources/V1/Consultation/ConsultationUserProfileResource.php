<?php

namespace App\Http\Resources\V1\Consultation;

use App\Repository\InfoRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConsultationUserProfileResource extends JsonResource
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
                    'type' => $this->type_value,
                    'subject' => __('messages.consultations_for : ').$this->subject,
                    'lawyer_name' => $this->lawyer?->name,
                    'lawyer_image' => $this->lawyer?->image,
                    'at' => $this->getFormattedDateAt(),
                    'is_new' => $this->is_new,
                ];
    }
}
