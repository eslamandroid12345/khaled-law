<?php

namespace App\Http\Services\Api\V1\Consultation;

use App\Http\Enums\ConsultationCaseEnum;
use App\Http\Enums\UserTypeEnum;
use App\Http\Resources\V1\Appointment\UserAppointmentResource;
use App\Http\Resources\V1\Chat\SimpleUserResource;
use App\Http\Resources\V1\Consultation\ConsultationCollection;
use App\Http\Resources\V1\Consultation\ConsultationLawyerCollection;
use App\Http\Resources\V1\Consultation\ConsultationResource;
use App\Http\Resources\V1\Consultation\OneConsultationResource;
use App\Http\Resources\V1\Order\OrderForLawyerCollection;
use App\Http\Services\Mutual\FileManagerService;
use App\Http\Services\Mutual\GetService;
use App\Http\Services\PlatformService;
use App\Http\Traits\Responser;
use App\Repository\AppointmentRepositoryInterface;
use App\Repository\ConsultationRepositoryInterface;
use App\Repository\ImageRepositoryInterface;
use App\Repository\InfoRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use Exception;
use http\Message;
use Illuminate\Support\Facades\DB;

abstract class ConsultationService extends PlatformService
{
    use Responser;

    public function __construct(
        private readonly ConsultationRepositoryInterface $consultationRepository,
        private readonly UserRepositoryInterface         $userRepository,
        private readonly ImageRepositoryInterface        $imageRepository,
        private readonly AppointmentRepositoryInterface  $appointRepository,
        private readonly FileManagerService              $fileManagerService,
        private readonly GetService                      $getService,
    )
    {
    }

    public function index()
    {
        $user = $this->userRepository->getById(auth()->user()->id);
        return $this->getService->handle(ConsultationCollection::class, $this->consultationRepository, 'getAllConsultationsForUser', parameters: [10], is_instance: true);
    }

    public function indexLawyer()
    {
        $user = $this->userRepository->getById(auth()->user()->id);
        return $this->responseSuccess(data: [
            'lawyer' => SimpleUserResource::make($user),
            'lawyer_consultations_count' => $user->consultationAsLawyerCount() ?? 0,
            'appointments' => UserAppointmentResource::collection($this->appointRepository->getMyAppointments()),
            'consultations' => ConsultationLawyerCollection::make($this->consultationRepository->getAllConsultationsForLawyer(10)),
        ]);
//        return $this->getService->handle(ConsultationLawyerCollection::class, $this->consultationRepository, 'getAllConsultationsForLawyer',parameters: [10],is_instance: true);
    }

    public function show($id)
    {
        return $this->getService->handle(OneConsultationResource::class, $this->consultationRepository, 'getById', parameters: [$id], is_instance: true);
    }

    public function cancelConsultation($id)
    {
        $consultation = $this->consultationRepository->getById($id, relations: ['appointments']);
        $consultation->appointments()?->delete();
        $consultation->update([
            'lawyer_id' => null,
            'case' => ConsultationCaseEnum::UNDER_REVIEW
        ]);
        return $this->responseSuccess();
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $data = $request->except('images', 'at');
            $data['user_id'] = auth()->user()->id;
            $consultation = $this->consultationRepository->create($data);
            $this->attachAttachments($consultation, $request->images);
            $this->storeAt($request, $consultation);
            DB::commit();
            return $this->responseSuccess(message: __('messages.created successfully'), data: new ConsultationResource($consultation, true));
        } catch (Exception $e) {
            DB::rollBack();
//             return $e;
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function uploadImages($images, $consultation)
    {
        if (is_array($images)) {
            foreach ($images as $index => $image) {
                $newImage = $this->fileManagerService->handle("images.$index", "consultation/images");
                $photo = $this->imageRepository->make(['path' => $newImage]);
                $consultation->images()->save($photo);
            }
        }
    }

    private function attachAttachments($consultation, $attachments)
    {
        if (is_array($attachments) && !empty($attachments)) {
            $data = [];
            foreach ($attachments as $attachment) {
                $data = [
                    'title' => $attachment['file']->getClientOriginalName(),
                    'type' => $attachment['type'],
                    'path' => $this->fileManagerService->uploadFile($attachment['file'], 'attachments'),
                ];
                $consultation->attachments()?->create($data);
            }
        }
    }

    public function storeAt($request, $consultation)
    {
        $data = [
            'title' => 'لديك استشارة جديدة مع : ' . $consultation->name,
            'date' => $request->at,
        ];
        $consultation->appointments()?->create($data);
    }

    public function updateDate($request, $id)
    {
        DB::beginTransaction();
        try {
            $consultation = $this->consultationRepository->getById($id);
            $consultation->appointments()?->delete();
            $consultation->appointments()?->create([
                'title' => 'لديك استشارة جديدة مع : ' . $consultation->name,
                'date' => $request->at,
            ]);
            DB::commit();
            return $this->responseSuccess(message: __('messages.updated successfully'));
        } catch (Exception $e) {
            DB::rollBack();
//             return $e;
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function cancel($id)
    {
        DB::beginTransaction();
        try {
            $consultation = $this->consultationRepository->getById($id);
            $consultation->appointments()->update(['meeting_link' => null]);
            DB::commit();
            return $this->responseSuccess(message: __('messages.updated successfully'));
        } catch (Exception $e) {
            DB::rollBack();
//             return $e;
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function getPrice($id)
    {
        DB::beginTransaction();
        try {
            $consultation = $this->consultationRepository->getById($id);
            if ($consultation->type == 'ONLINE') {
                return $this->responseSuccess(data: ['price' => app(InfoRepositoryInterface::class)->getValue('price_online')]);
            } else {
                return $this->responseSuccess(data: ['price' => app(InfoRepositoryInterface::class)->getValue('price_offline')]);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

}
