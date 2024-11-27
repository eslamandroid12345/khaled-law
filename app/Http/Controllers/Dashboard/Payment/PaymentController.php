<?php

namespace App\Http\Controllers\Dashboard\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Payment\PaymentRequest;
use App\Http\Services\Dashboard\Payment\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(
        private readonly PaymentService $service
    )
    {
        $this->middleware('check_permission:payments-create')->only('create','store');
        $this->middleware('check_permission:payments-delete')->only('destroy');
    }

    public function store($id, PaymentRequest $request)
    {
        return $this->service->store($id, $request);
    }

    public function destroy($id)
    {
        return $this->service->destroy($id);
    }
}
