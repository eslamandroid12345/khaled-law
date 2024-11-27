<?php

namespace App\Http\Controllers\Api\V1\Consultation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Consultation\ConsultationRequest;
use App\Http\Requests\Api\V1\Consultation\UpdateConsultationRequest;
use App\Http\Services\Api\V1\Consultation\ConsultationService;

class ConsultationController extends Controller
{
    public function __construct(
        private readonly ConsultationService $consultation,
    )
    {
        $this->middleware('auth:api');
        $this->middleware('type:LAWYER')->only('cancelConsultation');
    }

    public function index()
    {
        return $this->consultation->index();
    }

    public function indexLawyer()
    {
        return $this->consultation->indexLawyer();
    }

    public function store(ConsultationRequest $request)
    {
        return $this->consultation->store($request);
    }

    public function show($id)
    {
        return $this->consultation->show($id);
    }

    public function cancelConsultation($id)
    {
        return $this->consultation->cancelConsultation($id);
    }

    public function updateDate(UpdateConsultationRequest $request, $id)
    {
        return $this->consultation->updateDate($request, $id);
    }

    public function cancel($id)
    {
        return $this->consultation->cancel($id);
    }

    public function getPrice($id)
    {
        return $this->consultation->getPrice($id);
    }
}
