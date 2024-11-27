<?php

namespace App\Repository\Eloquent;

use App\Models\User;
use App\Repository\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends Repository implements UserRepositoryInterface
{
    protected Model $model;

    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function getActiveUsers()
    {
        return $this->model::query()->where('is_active', true);
    }

    public function getAllUsers($perPage)
    {
        return $this->model::query()->where('type', 'user')
            ->when(request()->has('search') && request('search') !== "", function ($query) {
                $searchTerm = '%' . request('search') . '%';
                $query->where(function ($query) use ($searchTerm) {
                    // Search main model's attributes
                    $query->where('name', 'like', $searchTerm)
                        ->orWhere('email', 'like', $searchTerm)
                        ->orWhere('phone', 'like', $searchTerm);
                });
            })
            ->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function getAllLawyers($perPage)
    {
        return $this->model::query()->where('type', 'lawyer')
            ->when(request()->has('search') && request('search') !== "", function ($query) {
                $searchTerm = '%' . request('search') . '%';
                $query->where(function ($query) use ($searchTerm) {
                    // Search main model's attributes
                    $query->where('name', 'like', $searchTerm)
                        ->orWhere('email', 'like', $searchTerm)
                        ->orWhere('phone', 'like', $searchTerm);
                });
            })
            ->latest()->paginate($perPage);
    }

    public function getAllListLawyers()
    {
        return $this->model::query()->where('type', 'lawyer')->get();
    }

    public function getAllLawyersWebsite()
    {
        return $this->model::query()->withAvg('reviewAsLaywer', 'rate')->where('is_active', true)->where('type', 'lawyer')->paginate(12);
    }

    public function getAllLawyersSearch()
    {
        $query = $this->model::query()->select(['id','name','image'])->where('is_active', true)->where('type', 'lawyer');
        $query->when(request()->has('search') && request('search') != null, function ($query) {
            $searchTerm = '%' . request('search') . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm);
            });
        });
        return $query->get();
    }

    public function getAllLawyersHome()
    {
        return $this->model::query()->withAvg('reviewAsLaywer', 'rate')->where('is_active', true)->where('type', 'lawyer')->latest()->limit(12)->get();
    }

    public function getOneLawyer($id)
    {
        return $this->model::withAvg('reviewAsLaywer', 'rate')->find($id);
    }

    public function countLawyers()
    {
        return $this->model::query()->where('type', 'lawyer')->count();
    }

    public function getUserDetails($id)
    {
        return $this->model::query()
            ->where('id', $id)
            ->withCount(['orders', 'consultationAsUser'])
            ->with(['orders', 'orders.lawyer:id,name,image', 'consultationAsUser', 'orders.service:id,name_ar,name_en'])
            ->first();

    }

    public function checkItem($byColumn, $value)
    {
        return $this->model::query()->where($byColumn, $value)->first();
    }

}
