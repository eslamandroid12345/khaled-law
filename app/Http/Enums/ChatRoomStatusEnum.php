<?php

namespace App\Http\Enums;

enum ChatRoomStatusEnum :string
{
    use Enumable;
    case CLOSE = 'CLOSE';
    case OPEN = 'OPEN';

}
