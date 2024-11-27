<?php

namespace App\Http\Services\Dashboard\Payment;

use App\Http\Requests\Dashboard\Payment\PaymentRequest;
use App\Repository\OrderRepositoryInterface;
use App\Repository\PaymentRepositoryInterface;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    public function __construct(
        private readonly OrderRepositoryInterface   $repository,
        private readonly PaymentRepositoryInterface $paymentRepository,
    )
    {

    }

    public function store($id, PaymentRequest $request)
    {
        try {
            DB::beginTransaction();
            $order = $this->repository->getById($id, ['id']);
            $data = $request->validated();
            $order->payments()?->create($data);
            DB::commit();
            return redirect()->back()->with(['success' => __('messages.created_successfully')]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->paymentRepository->delete($id);
            return redirect()->back()->with(['success' => __('messages.deleted_successfully')]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
