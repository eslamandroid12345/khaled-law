<?php

namespace App\Repository\Eloquent;

use App\Models\Review;
use App\Repository\ReviewRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class ReviewRepository extends Repository implements ReviewRepositoryInterface
{
    public function __construct(Review $model)
    {
        parent::__construct($model);
    }

    public function getAllReviewForUser($perPage)
    {
        if(auth()->user()->type == 'USER')
        {
            return $this->model::query()->where('user_id',auth()->user()->id)->with(['lawyer','user'])->orderBy('created_at','desc')->paginate($perPage);
        }
        else
        {
            return $this->model::query()->where('lawyer_id',auth()->user()->id)->with(['user','lawyer'])->orderBy('created_at','desc')->paginate($perPage);
        }
    }
}
