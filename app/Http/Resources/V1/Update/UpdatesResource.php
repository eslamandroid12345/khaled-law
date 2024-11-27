<?php

namespace App\Http\Resources\V1\Update;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UpdatesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'day' => $this->whenNotNull($this->dayFormat),
            'month' => $this->whenNotNull($this->monthFormat),
            'title' => $this->whenNotNull($this->title),
            'description' => $this->whenNotNull($this->description),
        ];
    }
}
