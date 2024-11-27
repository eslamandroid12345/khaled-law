<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\User\UpdateUserRequest;
use App\Http\Requests\Api\V1\User\UserPasswordRequest;
use App\Http\Services\Api\V1\User\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        private readonly UserService $service
    ){
        $this->middleware(['type:LAWYER'])->only(['getMyAppointments']);
        $this->middleware('auth:api');
        $this->middleware(['type:LAWYER'])->only(['getMyAppointments','getLawyerHome']);
    }
    public function getMyAppointments()
    {
        return $this->service->getMyAppointments();
    }

    public function getDetails()
    {
        return $this->service->getDetails();
    }
    public function getUserDetails($id)
    {
        return $this->service->getUserDetails($id);
    }
    public function getPayments()
    {
        return $this->service->getPayments();
    }

    public function updateMainData(UpdateUserRequest $request)
    {
        return $this->service->updateMainData($request);
    }

    public function changePassword(UserPasswordRequest $request)
    {
        return $this->service->changePassword($request);
    }
    public function getLawyerHome()
    {
        return $this->service->getLawyerHome();
    }
}
