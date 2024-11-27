<?php

namespace App\Repository\Eloquent;

use App\Models\LegalForm;
use App\Repository\LegalFormRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class LegalFormRepository extends Repository implements LegalFormRepositoryInterface
{
    protected Model $model;

    public function __construct(LegalForm $model)
    {
        parent::__construct($model);
    }

    public function getAllLegalForm()
    {
        return $this->model::query()->with('image')->where('is_active', true)->paginate(10);
    }

    public function getAllLegalFormsDashboard($perPage)
    {
        return $this->model::query()->with('image')
        ->when(request()->has('search') && request('search') !== "", function ($query) {
            $searchTerm = '%' . request('search') . '%';
            $query->where(function($query) use ($searchTerm) {
                $query->where('name_ar', 'like', $searchTerm)
                    ->orWhere('name_en', 'like', $searchTerm);
            });
        })
        ->orderBy('created_at','desc')->paginate($perPage);
    }

    public function getAllLegalFormsHome()
    {
        return $this->model::query()->with('image')->orderBy('created_at','desc')->latest()->limit(12)->get();
    }
}
