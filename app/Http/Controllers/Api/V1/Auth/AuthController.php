<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\SignInRequest;
use App\Http\Requests\Api\V1\Auth\SignUpRequest;
use App\Http\Requests\Api\V1\Auth\UserResetRequest;
use App\Http\Requests\Api\V1\Auth\UserConfirmRequest;
use App\Http\Requests\Api\V1\Auth\UserChangePasswordRequest;
use App\Http\Services\Api\V1\Auth\AuthService;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthService $auth,
    )
    {
    }

    public function signUp(SignUpRequest $request) {
        return $this->auth->signUp($request);
    }

    public function signIn(SignInRequest $request) {
        return $this->auth->signIn($request);
    }

    public function signOut()
    {
        return $this->auth->signOut();
    }

    public function whatIsMyPlatform()
    {
        return $this->auth->whatIsMyPlatform();
    }

    public function reset(UserResetRequest $request)
    {
        return $this->auth->reset($request);
    }

    public function resetUserconfirm(UserConfirmRequest $request)
    {
        return $this->auth->resetUserconfirm($request);
    }

    public function changePassword(UserChangePasswordRequest $request)
    {
        return $this->auth->changePassword($request);
    }
}
