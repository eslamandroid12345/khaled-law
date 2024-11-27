<?php

namespace App\Repository\Eloquent;

use App\Models\Otp;
use App\Repository\OtpRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class OtpRepository extends Repository implements OtpRepositoryInterface
{
    public function __construct(Otp $model)
    {
        parent::__construct($model);
    }

    public function generateOtp($user = null)
    {
        if ($user) {
            $user?->otp()?->delete();
            $id = $user->id;
        } else {
            auth('api')->user()?->otp()?->delete();
            $id = auth('api')->id();
        }
        return $this->model::query()->create([
            'user_id' => $id,
//            'otp' => rand(1234, 9999), //TODO
            'otp' => 1111,
            'expire_at' => Carbon::now()->addMinutes(5),
            'token' => Str::random(30),
        ]);
    }

    public function check($otp, $token)
    {
        return $this->model::query()
            ->where('user_id', auth('api')->id())
            ->where('otp', $otp)
            ->where('token', $token)
            ->where('expire_at', '>', Carbon::now())
            ->exists();
    }
}
