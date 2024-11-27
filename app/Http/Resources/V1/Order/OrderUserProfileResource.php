<?php

namespace App\Http\Resources\V1\Order;

use App\Http\Enums\OrderStatusEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderUserProfileResource extends JsonResource
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
            'lawyer_name' => $this->whenNotNull($this->lawyer?->name),
            'lawyer_image' => $this->whenNotNull($this->lawyer?->image),
            'status' => OrderStatusEnum::from($this->status)->t(),
            'status_value' => $this->status,
            'date' => $this->firstAppointmentDate,
        ];
    }
}
