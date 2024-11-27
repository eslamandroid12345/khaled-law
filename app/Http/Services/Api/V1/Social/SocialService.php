<?php

namespace App\Http\Services\Api\V1\Social;

use App\Http\Resources\V1\App\User\UserResource;
use App\Http\Services\Mutual\GetService;
use App\Http\Traits\GeneralTrait;
use App\Http\Traits\Responser;
use App\Repository\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Services\Mutual\FileManagerService;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\V1\Setting\SettingResource;

class SocialService
{
    use GeneralTrait;
    use Responser;

    public function __construct(
        private readonly UserRepositoryInterface    $userRepository,
        private readonly FileManagerService         $fileManagerService,
        private readonly GetService                 $getService,
    )
    {
    }

    public function redirect($provider)
    {
        $link = Socialite::with($provider)->stateless()->redirect()->getTargetUrl();
        return $this->returnData('data', $link);
    }

    public function callback($provider)
    {
        $userSocial = Socialite::with($provider)->stateless()->user();
        $user = $this->userRepository->first('email', $userSocial->getEmail());
        $phone = isset($userSocial->user['phone']) ? $userSocial->user['phone'] : null;
        if ($user)
        {
            $url = env('call_back_url');
            return redirect()->to($url . '?token=' . $user->token() . '&type=' . $user->type);
        }
        else
        {
            $user = $this->userRepository->create([
                                                        'phone' => $phone,
                                                        'name' => $userSocial->getName(),
                                                        'email' => $userSocial->getEmail(),
                                                        'image' => $userSocial->getAvatar(),
                                                        'provider_id' => $userSocial->getId(),
                                                        'provider' => $provider,
                                                        'is_active' => true,
                                                        'type' => 'USER',
                                                    ]);
            $url = env('call_back_url');
            return redirect()->to($url . '?token=' . $user->token() . '&type=' . $user->type);
        }
    }

}
