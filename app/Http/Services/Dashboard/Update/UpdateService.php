<?php

namespace App\Http\Services\Dashboard\Update;

use App\Http\Requests\Dashboard\Update\UpdateRequest;
use App\Repository\OrderRepositoryInterface;
use App\Repository\UpdatesRepositoryInterface;
use Illuminate\Support\Facades\DB;

class UpdateService
{
    public function __construct(
        private readonly OrderRepositoryInterface       $repository,
        private readonly UpdatesRepositoryInterface $updatesRepository,
    )
    {

    }

    public function store($id, UpdateRequest $request)
    {
        try {
            DB::beginTransaction();
            $order = $this->repository->getById($id, ['id']);
            $data = $request->validated();
            $order->updates()?->create($data);
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
            $this->updatesRepository->delete($id);
            return redirect()->back()->with(['success' => __('messages.deleted_successfully')]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
