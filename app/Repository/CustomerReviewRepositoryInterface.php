<?php

namespace App\Repository;

interface CustomerReviewRepositoryInterface extends RepositoryInterface
{
    public function getAllCustomerReviews();
    public function getAllCustomerReviewsDashboard($perPage);
}
