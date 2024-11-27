<?php

namespace App\Http\Services\Api\V1\Auth;

use App\Http\Enums\UserTypeEnum;
use App\Http\Requests\Api\V1\Auth\SignInRequest;
use App\Http\Requests\Api\V1\Auth\SignUpRequest;
use App\Http\Resources\V1\User\UserResource;
use App\Http\Services\PlatformService;
use App\Http\Traits\Responser;
use App\Repository\OtpRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use Exception;
use Mail;
use Illuminate\Support\Facades\Hash;
use App\Http\Mail\NotifyMail;
use Illuminate\Support\Facades\DB;

abstract class AuthService extends PlatformService
{
    use Responser;

    const NOT_ACTIVE = 0;

    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly OtpRepositoryInterface  $otpRepository,
    )
    {
    }

    public function signUp(SignUpRequest $request)
    {
        DB::beginTransaction();
        try
        {
            $data = $request->validated();
            $data['type'] = UserTypeEnum::USER->value;
            $user = $this->userRepository->create($data);
           $this->otpRepository->generateOtp($user);
            DB::commit();
            return $this->responseSuccess(message: __('messages.created successfully'), data: new UserResource($user, true));
        }
        catch (Exception $e)
        {
            DB::rollBack();
//            return $e;
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function signIn(SignInRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $token = auth('api')->attempt($credentials);
        if ($token)
        {
            if (auth('api')->user()->is_active == self::NOT_ACTIVE)
                return $this->responseFail(status: 401, data: __('messages.Your account is deactivated'));
            return $this->responseSuccess(message: __('messages.Successfully authenticated'), data: new UserResource(auth('api')->user(), true));
        }

        return $this->responseFail(status: 401, message: __('messages.wrong credentials'));
    }

    public function signOut()
    {
        auth('api')->logout();
        return $this->responseSuccess(message: __('messages.Successfully loggedOut'));
    }

    public function reset($request)
    {
        try
        {
            $user = $this->userRepository->checkItem('email',$request->email);
            if($user)
            {
                $randomNumber = random_int(1000, 9999);
                $details = [
                                'title' => 'Reset',
                                'body' =>  $randomNumber,
                            ];

                Mail::to($request->email)->send(new NotifyMail($details));
                $this->userRepository->update($user->id,['reset' => null]);
                $this->userRepository->update($user->id,['reset' => $randomNumber]);
                return $this->responseSuccess(message: __('dashboard.email_sent_successfully'));
            }
            else
            {
                return $this->responseFail(status: 422, message: __('dashboard.email_not_sent_successfully'));
            }
        }
        catch (\Exception $e)
        {
            return response()->json($e->getMessage(), 422);
        }
    }

    public function resetUserconfirm($request)
    {
        try
        {
            $user = $this->userRepository->checkItem('reset',$request->confirm);
            if($user)
            {
                return $this->responseSuccess(message: __('dashboard.code_Is_Confirm'));
            }
            else
            {
                return $this->responseFail(status: 422, message: __('dashboard.code_Not_Confirm'));
            }
        }
        catch (\Exception  $e)
        {
            return response()->json($e->getMessage(), 422);
        }
    }

    public function changePassword($request)
    {
        try
        {
            $user = $this->userRepository->checkItem('email',$request->email);
            if($user)
            {
                $this->userRepository->update($user->id,['password' => Hash::make($request->newpassword)]);
                $this->userRepository->update($user->id,['reset' => null]);
                return $this->responseSuccess(message: __('dashboard.password_Is_Changed'));
            }
            return $this->responseFail(status: 422, message: __('dashboard.User_Not_Found'));
        }
        catch (\Exception  $e)
        {
            return response()->json($e->getMessage(), 422);
        }
    }

}
