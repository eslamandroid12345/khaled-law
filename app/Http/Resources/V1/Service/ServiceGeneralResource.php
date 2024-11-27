<?php

namespace App\Http\Resources\V1\Service;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceGeneralResource extends JsonResource
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
            'title' => $this->whenNotNull($this->strL('name', true, 50)),
            'desc' => $this->whenNotNull($this->strL('desc', true, 100)),
            'image' => $this->whenNotNull($this->image?->imageUrl),
        ];
    }
}
