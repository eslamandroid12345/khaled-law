<?php

namespace App\Http\Controllers\Api\V1\Time;

use App\Http\Controllers\Controller;
use App\Http\Services\Api\V1\Time\TimeService;

class TimeController extends Controller
{
    public function __construct(
        private readonly TimeService $time,
    )
    {

    }

    public function index()
    {
        return $this->time->index();
    }

}
