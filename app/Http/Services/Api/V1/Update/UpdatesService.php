<?php

namespace App\Http\Services\Api\V1\Update;

use App\Http\Requests\Api\V1\Appointment\AppointmentRequest;
use App\Http\Requests\Api\V1\Attachment\AttachmentRequest;
use App\Http\Requests\Api\V1\Update\UpdatesRequest;
use App\Http\Services\Mutual\FileManagerService;
use App\Http\Traits\Responser;
use App\Repository\Eloquent\OrderRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class UpdatesService
{
    use Responser;

    public function __construct(
        private readonly OrderRepository $orderRepository,
    )
    {
    }

    public function store(UpdatesRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $order = $this->orderRepository->getById($data['order_id'], columns: ['id', 'user_id', 'lawyer_id']);
            if (!Gate::allows('access-order', $order))
                return $this->responseCustom(status: 422, message: __('messages.You are not authorized to access this resource'));
            unset($data['order_id']);
            $order->updates()?->create($data);
            DB::commit();
            return $this->responseSuccess(message: __('messages.created successfully'));
        } catch (\Exception $exception) {
            DB::rollBack();
//            return $exception;
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }
}
