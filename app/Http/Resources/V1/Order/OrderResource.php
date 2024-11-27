<?php

namespace App\Http\Resources\V1\Order;

use App\Http\Enums\OrderDataTypeEnum;
use App\Http\Resources\V1\Appointment\AppointmentResource;
use App\Http\Resources\V1\Attachment\AttachmentResource;
use App\Http\Resources\V1\Chat\SimpleUserResource;
use App\Http\Resources\V1\Payment\PaymentResource;
use App\Http\Resources\V1\Update\UpdatesResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'order_name' => $this->whenNotNull($this->orderName),
            'user' => SimpleUserResource::make($this->whenLoaded('user')),
            'lawyer' => SimpleUserResource::make($this->whenLoaded('lawyer')),
            'data_type' => OrderDataTypeEnum::from($this->data_type)->t(),
            'national_id' => $this->whenNotNull($this->national_id),
            'address' => $this->whenNotNull($this->address),
            'phone' => $this->whenNotNull($this->phone),
            'email' => $this->whenNotNull($this->email),
            'case_title' => $this->whenNotNull($this->case_title),
            'case_description' => $this->whenNotNull($this->case_description),
            'case_conclusion' => $this->whenNotNull($this->case_conclusion),
            'chat_room_id' => $this->chatroom?->id,
            'chat_unread_count' => $this->myParty?->unread_count,
            'appointments' => AppointmentResource::collection($this->whenLoaded('appointments')),
            'attachments' => AttachmentResource::collection($this->whenLoaded('attachments')),
            'updates' => UpdatesResource::collection($this->whenLoaded('updates')),
            'payments' => PaymentResource::collection($this->whenLoaded('payments')),
        ];
    }
}
