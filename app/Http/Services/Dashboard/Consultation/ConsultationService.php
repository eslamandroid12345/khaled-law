<?php

namespace App\Http\Services\Dashboard\Consultation;

use App\Models\Appointment;
use App\Repository\ConsultationRepositoryInterface;
use App\Repository\ImageRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Services\Mutual\FileManagerService;
use Illuminate\Support\Facades\DB;

class ConsultationService
{
    public function __construct(
        private readonly ConsultationRepositoryInterface $consultationRepository,
        private readonly UserRepositoryInterface         $userRepository,
        private readonly FileManagerService              $fileManagerService,
        private readonly ImageRepositoryInterface        $imageRepository,
    )
    {
    }

    public function index()
    {
        $consultations = $this->consultationRepository->getAllConsultationsDashboard(10);
        $lawyers = $this->userRepository->getAllListLawyers();
        return view('dashboard.site.consultations.index', compact('consultations', 'lawyers'));
    }

    public function show($id)
    {
        $consultation = $this->consultationRepository->getById($id);
        return view('dashboard.site.consultations.show', compact('consultation'));
    }

    public function edit($id)
    {
        $consultation = $this->consultationRepository->getById($id);
        return view('dashboard.site.consultations.edit', compact('consultation'));
    }

    public function update($request, $id)
    {
        try {
            DB::beginTransaction();
            $consultation = $this->consultationRepository->getById($id);
            $data = $request->validated();
            $this->consultationRepository->update($id, ['case' => $request->case]);
            $this->updateAppointemt($consultation, $request);
            DB::commit();
            return redirect()->route('consultations.index')->with(['success' => __('messages.updated_successfully')]);
        } catch (\Exception $e) {
            DB::rollBack();
//            return $e;
            return back()->with(['error' => __('messages.Something went wrong')]);
        }
    }

    private function updateAppointemt($consultation, $request)
    {
        if ($consultation->appointments()?->first())
            $consultation->appointments()?->first()?->update(['meeting_link' => $request->meet_link, 'date' => $request->date]);
        else
            $consultation->appointments()?->create(['meeting_link' => $request->meet_link, 'date' => $request->date]);
    }

    public function destroy($id)
    {
        try {
            $this->consultationRepository->delete($id);
            return redirect()->back()->with(['success' => __('messages.deleted_successfully')]);
        } catch (\Exception $e) {
            return back()->with(['error' => __('messages.Something went wrong')]);
        }
    }

    public function setLawyer($request, $id)
    {
        try {
            DB::beginTransaction();
            $consultation = $this->consultationRepository->getById($id);
            $data = $request->validated();
            $this->consultationRepository->update($consultation->id, ['lawyer_id' => $request->lawyer_id]);
            DB::commit();
            return redirect()->route('consultations.index')->with(['success' => __('messages.updated_successfully')]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with(['error' => __('messages.Something went wrong')]);
        }
    }
}
