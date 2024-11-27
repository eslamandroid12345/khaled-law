<?php

namespace App\Http\Controllers\Dashboard\Transaction;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Transaction\TransactionRequest;
use App\Http\Services\Dashboard\Transaction\TransactionService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct(
        private readonly TransactionService $transaction
    )
    {
        $this->middleware('check_permission:transaction-read')->only('index');
        $this->middleware('check_permission:transaction-update')->only('show','update');
    }

    public function index()
    {
        return $this->transaction->index();
    }

    public function show($id)
    {
        return $this->transaction->show($id);
    }

    public function update(TransactionRequest $request,$id)
    {
        return $this->transaction->update($request,$id);
    }
}
