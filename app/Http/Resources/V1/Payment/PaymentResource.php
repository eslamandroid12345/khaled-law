<?php

namespace App\Http\Resources\V1\Payment;

use App\Http\Enums\UserTypeEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            'name' => $this->whenNotNull($this->t('name')),
            'price' => $this->whenNotNull($this->price),
            'date' => $this->whenNotNull($this->dueDateValue),
            'is_paid' => $this->isPaid,
            'transaction_number' => $this->when(auth('api')->user()?->type == UserTypeEnum::USER->value, $this->whenNotNull($this->transaction?->id)),
        ];
    }
}
