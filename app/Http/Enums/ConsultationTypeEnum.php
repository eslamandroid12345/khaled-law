<?php

namespace App\Http\Enums;

enum ConsultationTypeEnum :string
{
    use Enumable;
    case ONLINE = 'ONLINE';
    case OFFLINE = 'OFFLINE';

    public function t()
    {
        return match ($this){
            self::ONLINE => __('website.online') ,
            self::OFFLINE => __('website.offline')
        };
    }
}
