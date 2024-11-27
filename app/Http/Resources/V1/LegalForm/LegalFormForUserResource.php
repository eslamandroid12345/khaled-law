<?php

namespace App\Http\Resources\V1\LegalForm;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LegalFormForUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
                    'id' => $this->transactionable->id,
                    'name' => $this->transactionable->t('name'),
                    'description' => $this->transactionable->t('description'),
                    'price' => $this->whenNotNull(number_format($this->price, 2, '.', ''), 0),
                    'counter' => $this->counter,
                    'file' => url($this->transactionable->file),
                    'image' => $this->transactionable->image->image_url,
                ];
    }
}
