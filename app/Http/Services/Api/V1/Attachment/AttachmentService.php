<?php

namespace App\Http\Services\Api\V1\Attachment;

use App\Http\Requests\Api\V1\Appointment\AppointmentRequest;
use App\Http\Requests\Api\V1\Attachment\AttachmentRequest;
use App\Http\Services\Mutual\FileManagerService;
use App\Http\Traits\Responser;
use App\Repository\AppointmentRepositoryInterface;
use App\Repository\Eloquent\OrderRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class AttachmentService
{
    use Responser;

    public function __construct(
        private readonly OrderRepository $orderRepository,
        private readonly FileManagerService $fileManagerService,
    )
    {
    }

    public function store(AttachmentRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $order = $this->orderRepository->getById($data['order_id'], columns: ['id', 'user_id', 'lawyer_id']);
            if (!Gate::allows('access-order', $order))
                return $this->responseCustom(status: 422, message: __('messages.You are not authorized to access this resource'));
            unset($data['order_id']);
            if (is_array($data['attachments']) && !empty($data['attachments'])) {
                $file = [];
                foreach ($data['attachments'] as $attachment) {
                    $file = [
                        'title' => $attachment['file']->getClientOriginalName(),
                        'type' => $attachment['type'],
                        'path' => $this->fileManagerService->uploadFile($attachment['file'], 'attachments'),
                    ];
                    $order->attachments()?->create($file);
                }
            }
            DB::commit();
            return $this->responseSuccess(message: __('messages.created successfully'));
        } catch (\Exception $exception) {
            DB::rollBack();
//            return $exception;
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }
}
