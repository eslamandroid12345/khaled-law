<?php

namespace App\Http\Controllers\Api\V1\CustomerReview;

use App\Http\Controllers\Controller;
use App\Http\Services\Api\V1\CustomerReview\CustomerReviewService;

class CustomerReviewController extends Controller
{
    public function __construct(
        private readonly CustomerReviewService $customerreview,
    )
    {
    }

    public function index()
    {
        return $this->customerreview->index();
    }

}
