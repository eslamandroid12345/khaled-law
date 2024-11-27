<?php

namespace App\Http\Resources\V1\Consultation;

use App\Http\Resources\V1\Attachment\AttachmentResource;
use App\Http\Resources\V1\User\OneUserResource;
use App\Http\Resources\V1\User\UserResource;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OneConsultationResource extends JsonResource
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
                    'type' => $this->type_value,
                    'type_value' => $this->type,
                    'status' => $this->status_value,
                    'subject' => __('messages.consultations_for : ').$this->subject,
                    'address' => $this->address,
                    'id_number' => $this->id_number,
                    'name' => $this->name,
                    'email' => $this->email,
                    'phone' => $this->phone,
                    'legal_question' => $this->legal_question,
                    'description' => $this->description,
                    'user' => auth()->user()->type == 'USER' ? new OneUserResource($this->lawyer) : new OneUserResource($this->user),
                    'meeting_link' => $this->appointments?->meeting_link,
                    'date' => $this->formatted_date,
                    'time' => $this->formatted_time,
                    'attachments' => AttachmentResource::collection($this->attachments),
                ];
    }
}
