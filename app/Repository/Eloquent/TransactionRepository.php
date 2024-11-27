<?php

namespace App\Repository\Eloquent;

use App\Models\Transaction;
use App\Repository\TransactionRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class TransactionRepository extends Repository implements TransactionRepositoryInterface
{
    public function __construct(Transaction $model)
    {
        parent::__construct($model);
    }

    public function getAllLegaFormForUser()
    {
        return $this->model::query()->with(['transactionable.image'])->where('transactionable_type','App\Models\LegalForm')->where('user_id',auth()->user()->id)->where('status',1)->orderBy('created_at','desc')->paginate(request('per_page'));
    }

    public function getAllTransactionDashboard($perPage)
    {
        return $this->model::query()->with('user')
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
        ->when(request()->has('search') && request('search') !== "", function ($query) {
            $searchTerm = '%' . request('search') . '%';
            $query->whereHas('user', function ($query) use ($searchTerm) {
                $query->where('name', 'like', $searchTerm);
            });
        })
        ->orderBy('created_at','desc')->paginate($perPage);
    }

}
