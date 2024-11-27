<?php

namespace App\Http\Controllers\Api\V1\Transaction;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Transaction\TransactionLegalFormRequest;
use App\Http\Requests\Api\V1\Transaction\TransactionRequest;
use App\Http\Services\Api\V1\Transaction\TransactionService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct(
        private readonly TransactionService $transaction
    )
    {
        $this->middleware('auth:api');
    }

    public function storeConsultation(TransactionRequest $request)
    {
        return $this->transaction->storeConsultation($request);
    }

    public function storeLegalForm(TransactionLegalFormRequest $request)
    {
        return $this->transaction->storeLegalForm($request);
    }
}
