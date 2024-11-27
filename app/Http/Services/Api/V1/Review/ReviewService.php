<?php

namespace App\Http\Services\Api\V1\Review;

use App\Http\Resources\V1\Service\ServiceCollection;
use App\Http\Resources\V1\Review\ReviewCollection;
use App\Http\Resources\V1\Service\ServiceResource;
use App\Http\Services\Mutual\GetService;
use App\Repository\ReviewRepositoryInterface;

class ReviewService
{

    public function __construct(
        private readonly GetService $get ,
        private readonly ReviewRepositoryInterface $reviewRepository ,
    )
    {

    }

    public function index()
    {
        $this->reviewRepository->getAllReviewForUser(10);
        return $this->get->handle(ReviewCollection::class,$this->reviewRepository,'getAllReviewForUser',[12],true);
    }
}
