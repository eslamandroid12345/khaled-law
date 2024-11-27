<?php

namespace App\Http\Services\Api\V1\Lawyer;

use App\Http\Services\Api\V1\Lawyer\LawyerService;

class LawyerWebService extends LawyerService
{
    public static function platform(): string
    {
        return 'website';
    }

    public function whatIsMyPlatform() : string // will be invoked if the request came from website endpoints
    {
        return 'platform: website!';
    }
}
