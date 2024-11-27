<?php

namespace App\Http\Resources\V1\Review;

use App\Http\Resources\PaginationResource;
use App\Http\Resources\V1\Lawyer\LawyerResource;
use App\Http\Resources\V1\LegalForm\LegalFormResource;
use App\Http\Resources\V1\Service\ServiceGeneralResource;
use App\Models\User;
use App\Repository\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ReviewCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'content' => $this->collection,
            'pagination' => PaginationResource::make($this),
        ];
    }
}
