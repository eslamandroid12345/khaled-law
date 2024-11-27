<?php

namespace App\Http\Resources\V1\CustomerReview;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' =>$this->t('name') ,
            'review' =>$this->t('review') ,
            'image' => $this->image?->image_url,
        ];
    }
}
