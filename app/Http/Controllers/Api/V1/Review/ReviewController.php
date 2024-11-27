<?php

namespace App\Http\Controllers\Api\V1\Review;

use App\Http\Controllers\Controller;
use App\Http\Services\Api\V1\Review\ReviewService;

class ReviewController extends Controller
{
    public function __construct(
        private readonly ReviewService $review,
    )
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        return $this->review->index();
    }

}
