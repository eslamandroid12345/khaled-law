<?php

namespace App\Http\Controllers\Api\V1\Appointment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Appointment\AppointmentRequest;
use App\Http\Services\Api\V1\Appointment\AppointmentService;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function __construct(
        private readonly AppointmentService $service
    )
    {
        $this->middleware('type:LAWYER')->only(['store']);
    }

    public function store(AppointmentRequest $request)
    {
        return $this->service->store($request);
    }
}
