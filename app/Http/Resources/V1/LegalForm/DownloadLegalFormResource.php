<?php

namespace App\Http\Resources\V1\LegalForm;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DownloadLegalFormResource extends JsonResource
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
            'name' => $this->t('name'),
            'description' => $this->t('description'),
            'price' => $this->whenNotNull(number_format($this->price, 2, '.', ''), 0),
            'image' => $this->image?->image_url,
            'file' => url($this->file),
        ];
    }
}
