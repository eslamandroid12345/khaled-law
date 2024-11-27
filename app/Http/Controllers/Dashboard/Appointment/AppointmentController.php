<?php

namespace App\Http\Controllers\Dashboard\Appointment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Apointment\AppointmentRequest;
use App\Http\Services\Dashboard\Appointment\AppointmentService;

class AppointmentController extends Controller
{
    public function __construct(
        private readonly AppointmentService $service
    )
    {
        $this->middleware('check_permission:appointments-create')->only('create','store');
        $this->middleware('check_permission:appointments-delete')->only('destroy');
    }

    public function store($id, AppointmentRequest $request)
    {
        return $this->service->store($id, $request);
    }

    public function destroy($id)
    {
        return $this->service->destroy($id);
    }
}
