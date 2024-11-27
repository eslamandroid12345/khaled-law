<?php

namespace App\Http\Controllers\Dashboard\Consultation;
use App\Http\Requests\Dashboard\Consultation\ConsultationRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Consultation\ConsultationUpdateRequest;
use App\Http\Services\Dashboard\Consultation\ConsultationService;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    public function __construct(private readonly ConsultationService $consultation)
    {
        $this->middleware('check_permission:consultations-read')->only('index');
        $this->middleware('check_permission:consultations-update')->only('edit','update');
        $this->middleware('check_permission:consultations-delete')->only('destroy');
    }

    public function index()
    {
        return $this->consultation->index();
    }

    public function show($id)
    {
        return $this->consultation->show($id);
    }

    public function edit($id)
    {
        return $this->consultation->edit($id);
    }

    public function update(ConsultationUpdateRequest $request, string $id)
    {
        return $this->consultation->update($request, $id);
    }

    public function destroy(string $id)
    {
        return $this->consultation->destroy($id);
    }
    public function setLawyer(ConsultationRequest $request,$id)
    {
        return $this->consultation->setLawyer($request,$id);
    }

}
