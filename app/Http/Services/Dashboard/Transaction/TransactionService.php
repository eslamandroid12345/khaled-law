<?php

namespace App\Http\Services\Dashboard\Transaction;

use App\Repository\TransactionRepositoryInterface;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    public function __construct(
        private readonly TransactionRepositoryInterface $transactionRepository,
    )
    {

    }

    public function index()
    {
        $transactions = $this->transactionRepository->getAllTransactionDashboard(10);
        return view('dashboard.site.transactions.index', compact('transactions'));
    }

    public function show($id)
    {
        $transaction = $this->transactionRepository->getById($id);
        return view('dashboard.site.transactions.show', compact('transaction'));
    }

    public function update($request, $id)
    {
        try
        {
            DB::beginTransaction();
            $transaction = $this->transactionRepository->getById($id);
            $data['status'] = $request->status ? 1 : 0;
            $this->transactionRepository->update($id, $data);
            DB::commit();
            return redirect()->back()->with(['success' => __('messages.updated_successfully')]);
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return back()->with(['error' => __('messages.Something went wrong')]);
        }
    }
}
