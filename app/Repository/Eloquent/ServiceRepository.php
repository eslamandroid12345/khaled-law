<?php

namespace App\Repository\Eloquent;

use App\Models\Service;
use App\Repository\ServiceRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class ServiceRepository extends Repository implements ServiceRepositoryInterface
{
    public function __construct(Service $model)
    {
        parent::__construct($model);
    }

    public function paginateServices($paginate)
    {
        $query = $this->model::query();
        if (request('category_id') != null)
            $query->where('category_id', request('category_id'));
        $query->with('image');
        return $query->paginate($paginate);
    }

    public function getAllServicesDashboard()
    {
        return $this->model::query()->with('image')
            ->when(request()->has('search') && request('search') !== "", function ($query) {
                $searchTerm = '%' . request('search') . '%';
                $query->where(function ($query) use ($searchTerm) {
                    $query->where('name_ar', 'like', $searchTerm)
                        ->orWhere('name_en', 'like', $searchTerm);
                });
            })
            ->latest()->paginate(10);
    }

    public function getAllServicesmsHome()
    {
        return $this->model::query()->with('image')->latest()->limit(8)->get();
    }

    public function getAllServiceSearch()
    {
        $query = $this->model::query();
        $query->when(request()->has('search') && request('search') != null, function ($query) {
            $searchTerm = '%' . request('search') . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name_ar', 'like', $searchTerm)->orWhere('name_ar', 'like', $searchTerm);
            });
        })->select(['id','name_ar','name_en']);
        return $query->get();
    }

}
