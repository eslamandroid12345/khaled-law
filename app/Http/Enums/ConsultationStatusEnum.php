<?php

namespace App\Http\Enums;

enum ConsultationStatusEnum :string
{
    use Enumable;
    case UNPAIED = 'UNPAIED';
    case PAIED = 'PAIED';

    public function t()
    {
        return match ($this){
            self::UNPAIED => __('website.unpaied') ,
            self::PAIED => __('website.paied')
        };
    }
}
