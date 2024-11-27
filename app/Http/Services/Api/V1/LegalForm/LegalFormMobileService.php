<?php

namespace App\Http\Services\Api\V1\LegalForm;

use App\Http\Services\Api\V1\LegalForm\LegalFormService;

class LegalFormMobileService extends LegalFormService
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
