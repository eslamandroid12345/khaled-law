<?php

namespace App\Http\Resources\V1\Service;

use App\Http\Resources\PaginationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ServiceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'content' => ServiceGeneralResource::collection($this->collection),
            'pagination' => PaginationResource::make($this),
        ];
    }
}
