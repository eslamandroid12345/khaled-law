<?php

namespace App\Http\Resources\V1\Uses;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class usesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id ,
            'title' =>$this->t('title') ,
            'description' =>$this->t('description') ,
            'image' => $this->image?->image_url,
        ];
    }
}
