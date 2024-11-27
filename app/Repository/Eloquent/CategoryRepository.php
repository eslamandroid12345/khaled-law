<?php

namespace App\Repository\Eloquent;

use App\Models\Category;
use App\Repository\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class CategoryRepository extends Repository implements CategoryRepositoryInterface
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    public function getAllCategoriesDashboard($perPage)
    {
        return $this->model::query()
            ->when(request()->has('search') && request('search') !== "", function ($query) {
                $searchTerm = '%' . request('search') . '%';
                $query->where(function($query) use ($searchTerm) {
                    $query->where('name_ar', 'like', $searchTerm)
                    ->orWhere('name_ar', 'like', $searchTerm);
                });
            })
        ->orderBy('created_at','desc')->paginate($perPage);
    }

}
