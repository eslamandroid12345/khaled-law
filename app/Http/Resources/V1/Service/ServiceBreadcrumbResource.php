<?php

namespace App\Http\Resources\V1\Service;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceBreadcrumbResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'service_id' => $this->id,
            'service_name' => $this->whenNotNull($this->strL('name', true, 50)),
            'category_id' => $this->category?->id,
            'category_name' => $this->category->t('name'),
        ];
    }
}
