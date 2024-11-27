<?php

namespace App\Http\Enums;

enum OrderStatusEnum: string
{
    use Enumable;

    case UNDER_REVIEW = 'UNDER_REVIEW';
    case WAITING_PAYMENT = 'WAITING_PAYMENT';
    case IN_PROGRESS = 'IN_PROGRESS';
    case FINISHED = 'FINISHED';

    public function t()
    {
        return match ($this) {
            self::UNDER_REVIEW => __('website.UNDER_REVIEW'),
            self::WAITING_PAYMENT => __('website.WAITING_PAYMENT'),
            self::IN_PROGRESS, => __('website.IN_PROGRESS'),
            self::FINISHED, => __('website.FINISHED'),
        };
    }
}
