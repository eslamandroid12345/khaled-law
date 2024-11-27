<?php

namespace App\Http\Services\Api\V1\Appointment;

use App\Http\Requests\Api\V1\Appointment\AppointmentRequest;
use App\Http\Traits\Responser;
use App\Repository\AppointmentRepositoryInterface;
use App\Repository\Eloquent\OrderRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class AppointmentService
{
    use Responser;

    public function __construct(
        private readonly AppointmentRepositoryInterface $repository,
        private readonly OrderRepository                $orderRepository,
    )
    {
    }

    public function store(AppointmentRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $order = $this->orderRepository->getById($data['order_id'], columns: ['id', 'user_id', 'lawyer_id']);
            if (!Gate::allows('access-order', $order))
                return $this->responseCustom(status: 422, message: __('messages.You are not authorized to access this resource'));
            unset($data['order_id']);
            $order->appointments()?->create($data);
            DB::commit();
            return $this->responseSuccess(message: __('messages.created successfully'));
        } catch (\Exception $exception) {
            DB::rollBack();
//            return $exception;
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }
}
