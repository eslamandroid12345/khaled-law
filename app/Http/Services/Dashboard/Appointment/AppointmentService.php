<?php

namespace App\Http\Services\Dashboard\Appointment;

use App\Http\Requests\Dashboard\Apointment\AppointmentRequest;
use App\Repository\AppointmentRepositoryInterface;
use App\Repository\OrderRepositoryInterface;
use Illuminate\Support\Facades\DB;

class AppointmentService
{
    public function __construct(
        private readonly OrderRepositoryInterface       $repository,
        private readonly AppointmentRepositoryInterface $appointmentRepository,
    )
    {

    }

    public function store($id, AppointmentRequest $request)
    {
        try {
            DB::beginTransaction();
            $order = $this->repository->getById($id, ['id']);
            $data = $request->validated();
            $order->appointments()?->create($data);
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
            $this->appointmentRepository->delete($id);
            return redirect()->back()->with(['success' => __('messages.deleted_successfully')]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
