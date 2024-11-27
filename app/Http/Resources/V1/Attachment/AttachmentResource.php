<?php

namespace App\Http\Resources\V1\Attachment;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttachmentResource extends JsonResource
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
            'title' => $this->whenNotNull($this->title) ,
            'icon' => $this->whenNotNull($this->iconUrl) ,
            'preview' => $this->whenNotNull($this->url) ,
            'created_at' => $this->createdAtFormat ,
            'type' => $this->type ,
        ];
    }
}
