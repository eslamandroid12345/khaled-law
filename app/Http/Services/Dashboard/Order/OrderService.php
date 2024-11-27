<?php

namespace App\Http\Services\Dashboard\Order;

use App\Events\ChatRoomStatusChange;
use App\Http\Enums\ChatRoomStatusEnum;
use App\Http\Enums\OrderStatusEnum;
use App\Repository\CategoryRepositoryInterface;
use App\Repository\ChatRoomRepositoryInterface;
use App\Repository\ImageRepositoryInterface;
use App\Repository\OrderRepositoryInterface;

use App\Http\Services\Mutual\FileManagerService;
use App\Repository\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function __construct(
        private readonly OrderRepositoryInterface    $repository,
        private readonly UserRepositoryInterface     $userRepository,
        private readonly ChatRoomRepositoryInterface $chatRoomRepository,
        private readonly ImageRepositoryInterface    $imageRepository,
    )
    {
    }

    public function index()
    {
        $lawyers = $this->userRepository->getAllListLawyers();
        $orders = $this->repository->paginateAllOrdersDashboard(20);
        return view('dashboard.site.orders.index', compact('orders', 'lawyers'));
    }

    public function show($id)
    {
        $order = $this->repository->getById($id,
            relations: ['user', 'lawyer', 'service', 'attachments', 'appointments', 'payments.transaction', 'reviews']);
        return view('dashboard.site.orders.show', compact('order'));
    }

    public function changeLawyer($order_id)
    {
        $order = $this->repository->getById($order_id, ['id', 'user_id'], ['chatroom']);
        $order->chatroom()?->delete();
        $this->repository->update($order_id, [
            'lawyer_id' => request('lawyer_id'),
        ]);
        $this->chatRoomRepository->provideForDashboard($order->user_id, request('lawyer_id'), $order->id);
    }

    public function changeStatus($order_id)
    {
        $order = $this->repository->getById($order_id, ['id'], relations: ['chatroom']);
        if (request('status') == OrderStatusEnum::FINISHED->value) {
            $order->chatroom()?->update(['status' => ChatRoomStatusEnum::CLOSE->value]);
            broadcast(new ChatRoomStatusChange($order->chatroom->id, ChatRoomStatusEnum::CLOSE->value))->toOthers();
        } else {
            $order->chatroom()?->update(['status' => ChatRoomStatusEnum::OPEN->value]);
            broadcast(new ChatRoomStatusChange($order->chatroom->id, ChatRoomStatusEnum::OPEN->value))->toOthers();
        }
        $this->repository->update($order_id, [
            'status' => request('status'),
        ]);
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $order = $this->repository->getById($id, ['id']);
            $order->updates()?->delete();
            $order->payments()?->delete();
            $order->appointments()?->delete();
            $order->attachments()?->delete();
            $order->chatroom()?->delete();
            $this->repository->delete($id);
            DB::commit();
            return redirect()->back()->with(['success' => __('messages.deleted_successfully')]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with(['error' => __('messages.Something went wrong')]);
        }
    }

    public function chat($order)
    {
        $messages = $this->repository->getById($order, ['id'], ['chatroom.messages.user'])->chatroom?->messages;
        return view('dashboard.site.orders.chat', compact('messages'));
    }
}
