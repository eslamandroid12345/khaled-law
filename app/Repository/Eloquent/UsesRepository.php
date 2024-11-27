<?php

namespace App\Repository\Eloquent;

use App\Models\Uses;
use App\Repository\UsesRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class UsesRepository extends Repository implements UsesRepositoryInterface
{
    public function __construct(Uses $model)
    {
        parent::__construct($model);
    }

    public function getAllUsesDashboard($perPage)
    {
        return $this->model::query()->with(['image'])
        ->when(request()->has('search') && request('search') !== "", function ($query) {
            $searchTerm = '%' . request('search') . '%';
            $query->where(function($query) use ($searchTerm) {
                $query->where('title_ar', 'like', $searchTerm)
                    ->orWhere('title_en', 'like', $searchTerm);
            });
        })
        ->orderByRaw('sort IS NULL, sort ASC')->paginate($perPage);
    }

    public function getAllUses()
    {
        return $this->model::query()->with(['image'])->orderByRaw('sort IS NULL, sort ASC')->get();
    }

}
