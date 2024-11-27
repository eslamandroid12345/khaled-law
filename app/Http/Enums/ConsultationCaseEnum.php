<?php

namespace App\Http\Enums;

enum ConsultationCaseEnum :string
{
    use Enumable;
    case NEW = 'NEW';
    case UNDER_REVIEW = 'UnderReview';
    case FINISHED = 'FINISHED';

    public function t()
    {
        return match ($this){
            self::NEW => __('website.NEW') ,
            self::UNDER_REVIEW => __('website.UNDER_REVIEW') ,
            self::FINISHED => __('website.FINISHED')
        };
    }
}
