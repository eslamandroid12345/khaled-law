<?php

namespace App\Http\Resources\V1\Review;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
            'rate' => $this->whenNotNull($this->rate),
            'message' => $this->whenNotNull($this->message),
            'user_name' => $this->user ? $this->whenNotNull($this->user?->name) : $this->whenNotNull($this->lawyer?->name),
            'user_image' => $this->user ? $this->whenNotNull($this->user?->image) : $this->whenNotNull($this->lawyer?->image),
            'date' => $this->created_at->format('j/n/Y')
        ];
    }
}
