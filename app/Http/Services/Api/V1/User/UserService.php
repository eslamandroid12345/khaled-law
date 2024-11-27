<?php

namespace App\Http\Services\Api\V1\User;

use App\Http\Resources\V1\Appointment\UserAppointmentResource;
use App\Http\Resources\V1\Consultation\ConsultationLawyerResource;
use App\Http\Resources\V1\Consultation\ConsultationUserProfileResource;
use App\Http\Resources\V1\Order\OrderForLawyerResource;
use App\Http\Resources\V1\Order\OrderUserProfileResource;
use App\Http\Resources\V1\Payment\PaymentProfileResource;
use App\Http\Resources\V1\Payment\PaymentResource;
use App\Http\Resources\V1\User\OneUserResource;
use App\Http\Services\Mutual\FileManagerService;
use App\Http\Traits\Responser;
use App\Repository\Eloquent\AppointmentRepository;
use App\Repository\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\V1\Chat\SimpleUserResource;
use App\Http\Resources\V1\Order\OrderForLawyerCollection;
use App\Http\Services\Mutual\GetService;
use App\Repository\OrderRepositoryInterface;

class UserService
{
    use Responser;

    public function __construct(
        private readonly AppointmentRepository    $repository,
        private readonly UserRepositoryInterface  $userRepository,
        private readonly FileManagerService       $fileManagerService,
        private readonly GetService               $get,
        private readonly AppointmentRepository    $appointmentRepository,
        private readonly OrderRepositoryInterface $orderRepository,
    )
    {
    }

    public function getMyAppointments()
    {
        return $this->get->handle(UserAppointmentResource::class, $this->appointmentRepository, 'getMyAppointments');
    }

    public function getPayments()
    {
        $payments = auth('api')->user()->load(
            ['payments.transaction', 'payments.order:id,service_id', 'payments.order.service:id,name_ar,name_en'])->payments;
        return $this->responseSuccess(data: PaymentProfileResource::collection($payments));
    }

    public function getLawyerHome()
    {
        $user = auth('api')->user()?->loadCount('lawyerOrders');
        return $this->responseSuccess(data: [
            'user' => SimpleUserResource::make($user),
            'lawyer_orders_count' => $user->lawyer_orders_count ?? 0,
            'appointments' => UserAppointmentResource::collection($this->appointmentRepository->getMyAppointments()),
            'orders' => OrderForLawyerCollection::make($this->orderRepository->paginateLawyerOrders(10)),
        ]);
    }

    public function getDetails()
    {
        return $this->get->handle(OneUserResource::class, $this->userRepository, 'getById', parameters: [auth()->user()->id], is_instance: true);
    }

    public function getUserDetails($id)
    {
        $user = $this->userRepository->getUserDetails($id);
        $data = [
            'user' => SimpleUserResource::make($user),
            'orders_count' => $user->orders_count,
            'consultation_count' => $user->consultation_as_user_count,
            'orders' => OrderUserProfileResource::collection($user->orders),
            'consultations' => ConsultationUserProfileResource::collection($user->consultationAsUser),
        ];
        return $this->responseSuccess(data: $data);
    }

    public function updateMainData($request)
    {
        try {
            $id = auth()->user()->id;
            $user = $this->userRepository->getById($id);
            $data = $request->validated();
            if ($request->hasFile('image')) {
                $image = $this->fileManagerService->handle("image", "user/images", $user->getRawOriginal('image'));
                $data['image'] = $image;
            } else {
                unset($data['image']);
            }
            $this->userRepository->update($id, $data);
            $new_user = $this->userRepository->getById($id);
            return $this->responseSuccess(message: __('messages.updated successfully'), data: new OneUserResource($new_user));
        } catch (\Exception $e) {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function changePassword($request)
    {
        try {
            $id = auth()->user()->id;
            $user = $this->userRepository->getById($id);
            if (Hash::check($request->current_password, $user->password)) {
                $this->userRepository->update($user->id, ['password' => Hash::make($request->password)]);
                return $this->responseSuccess(message: __('messages.updated successfully'));
            } else {
                return $this->responseFail(message: __('messages.old_password_is_not_correct'));
            }
        } catch (\Exception $e) {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }
}
