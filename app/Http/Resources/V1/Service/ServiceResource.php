<?php

namespace App\Http\Resources\V1\Service;

use App\Http\Resources\V1\Question\QuestionResource;
use App\Http\Resources\V1\Review\ReviewResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
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
            'name' => $this->t('name'),
            'desc' => $this->t('desc'),
            'required_files' => $this->t('required_files'),
            'price' => $this->whenNotNull($this->priceTitle),
            'image' => $this->whenNotNull($this->image?->imageUrl),
            'reviews' => ReviewResource::collection($this->whenLoaded('reviews')),
            'questions' => QuestionResource::collection($this->whenLoaded('questions')),
            // TODO : Complete this resource for relations
        ];
    }
}
