<?php

namespace App\Http\Resources\V1\Lawyer;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LawyerResource extends JsonResource
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
                    'name' => $this->name,
                    'job_title' => $this->t('job_title'),
                    'rate' => floor($this->review_as_laywer_avg_rate ?? 0),
                    'image' => $this->image,
                ];
    }
}
