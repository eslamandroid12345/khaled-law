<?php

namespace App\Http\Resources\V1\User;

use App\Http\Resources\V1\Question\QuestionResource;
use App\Http\Resources\V1\Review\ReviewResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OneUserResource extends JsonResource
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
            'image' => $this->image,
            'phone' => $this->phone,
            'email' => $this->email,
            'is_verified' => $this->isVerified,
            'otp_token' => $this->whenNotNull($this->otpToken),
        ];
    }
}
