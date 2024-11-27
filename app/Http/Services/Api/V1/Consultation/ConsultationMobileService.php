<?php

namespace App\Http\Services\Api\V1\Consultation;

use App\Http\Services\Api\V1\Consultation\ConsultationService;

class ConsultationMobileService extends ConsultationService
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
