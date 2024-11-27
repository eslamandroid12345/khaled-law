<?php

namespace App\Http\Services\Api\V1\Order;

use App\Http\Enums\OrderStatusEnum;
use App\Http\Requests\Api\V1\Order\OrderRequest;
use App\Http\Requests\Api\V1\Order\OrderReviewRequest;
use App\Http\Resources\V1\Order\OrderForUserCollection;
use App\Http\Resources\V1\Order\OrderResource;
use App\Http\Services\Api\V1\Order\Helpers\OrderHelperService;
use App\Http\Services\Mutual\FileManagerService;
use App\Http\Services\Mutual\GetService;
use App\Http\Traits\Responser;
use App\Repository\ChatRoomRepositoryInterface;
use App\Repository\OrderRepositoryInterface;
use App\Repository\PaymentRepositoryInterface;
use App\Repository\ReviewRepositoryInterface;
use App\Repository\ServiceRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class OrderService
{
    use Responser;

    public function __construct(
        private readonly OrderRepositoryInterface  $repository,
        private readonly ReviewRepositoryInterface $reviewRepository,
        private readonly OrderHelperService        $helper,
        private readonly GetService                $getService,
    )
    {

    }

    public function index()
    {
        return $this->getService->handle(OrderForUserCollection::class, $this->repository, 'paginateCustomerOrders', [12], true);
    }

    public function show($id)
    {
        $order = $this->repository->getById($id,
            relations: ['lawyer:id,name,image', 'user:id,name,image', 'chatroom:id,order_id', 'myParty', 'appointments', 'attachments', 'updates', 'payments.transaction','service:id,name_ar,name_en']);
        if (!Gate::allows('access-order', $order))
            return $this->responseCustom(status: 422, message: __('messages.You are not authorized to access this resource'));
        return $this->responseSuccess(data: OrderResource::make($order));
    }

    public function store(OrderRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->except('attachments');
            $data['user_id'] = auth('api')->id();
            $order = $this->repository->create($data);
            $this->helper->attachAttachments($order, $request->attachments);
            if ($request->lawyer_id != null)
                $this->helper->startChat($order);
            if ($request->service_id != null)
                $this->helper->attachFirstPayment($request->service_id, $order);
            DB::commit();
            return $this->responseSuccess(message: __('messages.The order has been sent successfully.'));
        } catch (\Exception $exception) {
            DB::rollBack();
//            return $exception;
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function storeReview(OrderReviewRequest $request)
    {
        try {
            DB::beginTransaction();
            $order = $this->repository->getById($request->order_id, columns: ['id', 'lawyer_id', 'user_id', 'status'], relations: ['reviews:id,order_id']);
            if (Gate::allows('cannot-store-review', $order))
                return $this->responseFail(status: 422, message: __('messages.You cannot review this order .'));
            $data = $request->except('order_id');
            $data['user_id'] = auth('api')->id();
            $data['lawyer_id'] = $order->lawyer_id;
            $data['order_id'] = $order->id;
            $this->reviewRepository->create($data);
            DB::commit();
            return $this->responseSuccess(message: __('messages.The review has been sent successfully.'));
        } catch (\Exception $exception) {
            DB::rollBack();
//            return $exception;
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }
}
