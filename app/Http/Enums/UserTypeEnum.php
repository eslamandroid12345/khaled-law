<?php

namespace App\Http\Enums;

enum UserTypeEnum :string
{
    use Enumable;
    case USER = 'USER';
    case LAWYER = 'LAWYER';

    public function t(){
        return match ($this){
            self::USER => __('website.user') ,
            self::LAWYER => __('website.lawyer')
        };
    }
}
