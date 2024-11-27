<?php

namespace App\Http\Resources\V1\LegalForm;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LegalFormOrderResource extends JsonResource
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
            'name' => $this->legalForm->t('name'),
            'description' => $this->legalForm->t('description'),
            'price' => $this->whenNotNull(number_format($this->legalForm->price, 2, '.', ''), 0),
            'image' => $this->legalForm->image?->image_url,
            'counter' => $this->counter,
            'legal_form_id' => $this->legalForm->id,
            'total_price' => number_format($this->counter * $this->whenNotNull($this->legalForm->price, 0), 2, '.', ''),
        ];
    }
}
