<?php

namespace App\Repository\Eloquent;

use App\Models\CustomerReview;
use App\Repository\CustomerReviewRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class CustomerReviewRepository extends Repository implements CustomerReviewRepositoryInterface
{
    public function __construct(CustomerReview $model)
    {
        parent::__construct($model);
    }

    public function getAllCustomerReviews()
    {
        return $this->model::query()->with('image')->latest()->limit(9)->get();
    }
    public function getAllCustomerReviewsDashboard($perPage)
    {
        return $this->model::query()->with('image')
        ->when(request()->has('search') && request('search') !== "", function ($query) {
            $searchTerm = '%' . request('search') . '%';
            $query->where(function($query) use ($searchTerm) {
                $query->where('name_ar', 'like', $searchTerm)
                    ->orWhere('name_en', 'like', $searchTerm);
            });
        })
        ->latest()->paginate($perPage);
    }

}
