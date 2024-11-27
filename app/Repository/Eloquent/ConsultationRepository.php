<?php

namespace App\Repository\Eloquent;

use App\Models\Consultation;
use App\Repository\ConsultationRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class ConsultationRepository extends Repository implements ConsultationRepositoryInterface
{
    protected Model $model;

    public function __construct(Consultation $model)
    {
        parent::__construct($model);
    }

    public function getAllConsultationsDashboard($perPage)
    {
        return $this->model::query()->with(['images','lawyer','appointments'])
        ->when(request()->has('type') && request('type') !== "", function ($query) {
            $typeTerm = request('type');
            $query->where(function($query) use ($typeTerm) {
                $query->where('type', $typeTerm);
            });
        })
        ->when(request()->has('status') && request('status') !== "", function ($query) {
            $statusTerm = request('status');
            $query->where(function($query) use ($statusTerm) {
                $query->where('status', $statusTerm);
            });
        })
        // ->when(request()->has('search') && request('search') !== "", function ($query) {
        //     $searchTerm = '%' . request('search') . '%';
        //     $query->whereHas('user', function ($query) use ($searchTerm) {
        //         $query->where('name', 'like', $searchTerm);
        //     });
        // })
        ->when(request()->has('search') && request('search') !== "", function ($query) {
            $searchTerm = '%' . request('search') . '%';
            $query->where('name', 'like', $searchTerm);
        })
        ->orderBy('created_at','desc')->paginate($perPage);
    }

    public function getAllConsultationsForUser($perPage)
    {
        return $this->model::query()->whereNotNull('lawyer_id')->where('user_id',auth('api')->user()->id)->with(['images','lawyer','appointments','user'])->orderBy('created_at','desc')->paginate($perPage);
    }

    public function getAllConsultationsForLawyer($perPage)
    {
        return $this->model::query()->whereNotNull('lawyer_id')->where('lawyer_id',auth('api')->user()->id)->with(['images','lawyer','appointments','user'])->orderBy('created_at','desc')->paginate($perPage);
    }

}
