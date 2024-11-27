<?php

namespace App\Http\Services\Api\V1\Lawyer;

use App\Http\Services\Api\V1\Lawyer\LawyerService;

class LawyerMobileService extends LawyerService
{
    public static function platform(): string
    {
        return 'mobile';
    }

    public function whatIsMyPlatform() : string // will be invoked if the request came from mobile endpoints
    {
        return 'platform: mobile!';
    }
}
