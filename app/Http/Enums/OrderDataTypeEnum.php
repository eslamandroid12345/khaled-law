<?php

namespace App\Http\Enums;

enum OrderDataTypeEnum :string
{
    use Enumable;
    case MY = 'MY';
    case CLIENT = 'CLIENT';

    public function t(){
        return match ($this){
            self::MY => __('website.MY') ,
            self::CLIENT => __('website.CLIENT')
        };
    }
}
