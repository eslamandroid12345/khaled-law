<?php

namespace App\Http\Enums;

enum AttachmentTypeEnum :string
{
    use Enumable;
    case FILE = 'FILE';
    case IMAGE = 'IMAGE';

    public function t(){
        return match ($this){
            self::FILE => __('website.MY') ,
            self::IMAGE => __('website.CLIENT')
        };
    }
}
