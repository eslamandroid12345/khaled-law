<?php

namespace App\Repository\Eloquent;

use App\Http\Enums\UserTypeEnum;
use App\Models\Order;
use App\Repository\OrderRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class OrderRepository extends Repository implements OrderRepositoryInterface
{
    public function __construct(Order $model)
    {
        parent::__construct($model);
    }

    public function paginateCustomerOrders($paginate)
    {
        $query = $this->model::query();
        $query->select(['id', 'status', 'user_id', 'lawyer_id', 'service_id']);
        $query->where('user_id', auth('api')->id());
        if (request('status') != null)
            $query->where('status', request('status'));
        $query->with(['service:id,name_ar,name_en', 'service.image', 'lawyer:id,name,image']);
        return $query->paginate($paginate);
    }

    public function paginateLawyerOrders($paginate)
    {
        $query = $this->model::query();
        $query->select(['id', 'status', 'user_id', 'lawyer_id', 'service_id']);
        $query->where('lawyer_id', auth('api')->id());
        if (request('status') != null)
            $query->where('status', request('status'));
        if (request('category_id') != null)
            $query->whereHas('service', function ($q) {
                $q->where('category_id', request('category_id'));
            });
        $query->with(['service:id,name_ar,name_en,category_id', 'user:id,name,image', 'firstAppointment']);
        return $query->paginate($paginate);
    }


    public function paginateAllOrdersDashboard($paginate)
    {
        $query = $this->model::query()
        ->when(request()->has('search') && request('search') !== "", function ($query) {
            $searchTerm = '%' . request('search') . '%';
            $query->whereHas('user', function ($query) use ($searchTerm) {
                $query->where('name', 'like', $searchTerm);
            })
            ->orWhereHas('lawyer', function ($query) use ($searchTerm) {
                $query->where('name', 'like', $searchTerm);
            });
            // ->orWhereHas('service', function ($query) use ($searchTerm) {
            //     $query->where('name_ar', 'like', $searchTerm)
            //         ->orWhere('name_en', 'like', $searchTerm);
            // });
        });
        $query->select(['id', 'status', 'user_id', 'lawyer_id', 'service_id','case_title','phone']);
        $query->with(['service:id,name_ar,name_en,category_id', 'user:id,name,image', 'lawyer:id,name,image', 'firstAppointment']);
        return $query->latest()->paginate($paginate);
    }
    public function getLatestOrdersDashboard(){
        $query = $this->model::query();
        $query->select(['id', 'status', 'user_id', 'lawyer_id', 'service_id','case_title','phone']);
        $query->with(['service:id,name_ar,name_en,category_id', 'user:id,name,image', 'lawyer:id,name,image', 'firstAppointment']);
        return $query->limit(10)->get();
    }



}
