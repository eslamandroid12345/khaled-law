<?php

namespace App\Http\Resources\V1\Time;

use App\Http\Resources\V1\Question\QuestionResource;
use App\Http\Resources\V1\Review\ReviewResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TimeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'hour' => $this['hour'] ?? null,
            'is_active' => $this['is_active'] ?? null,
        ];
    }
}
