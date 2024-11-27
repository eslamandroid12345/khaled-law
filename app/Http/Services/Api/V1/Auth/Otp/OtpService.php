<?php

namespace App\Http\Services\Api\V1\Auth\Otp;

use App\Http\Resources\V1\Otp\OtpResource;
use App\Http\Traits\Responser;
use App\Repository\OtpRepositoryInterface;
use Illuminate\Support\Facades\DB;

class OtpService
{
    use Responser;

    public function __construct(
        private readonly OtpRepositoryInterface $otpRepository,
    )
    {

    }

    public function generate()
    {
        $otp = $this->otpRepository->generateOtp();
        //TODO:  Send otp via SMS
        return $this->responseSuccess(message: __('messages.OTP_Is_Send'),data: OtpResource::make($otp));
    }

    public function verify($request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            if (!$this->otpRepository->check($data['otp'], $data['otp_token']))
                return $this->responseFail(message: __('messages.Wrong OTP code or expired'));
            auth('api')->user()?->otp()?->delete();
            DB::commit();
            return $this->responseSuccess(message: __('messages.Your account has been verified successfully'));
        } catch (\Exception $e) {
            // return $e;
            DB::rollBack();
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

}
