<?php

namespace App\Http\Services\Api\V1\Time;

use App\Http\Resources\V1\Time\TimeResource;
use App\Http\Services\Mutual\GetService;
use App\Repository\TimeRepositoryInterface;
use Carbon\Carbon;

class TimeService
{

    public function __construct(
        private readonly GetService $get ,
        private readonly TimeRepositoryInterface $timeRepository ,
    )
    {

    }

    public function index()
    {
        return $this->get->handle(TimeResource::class,$this->timeRepository,method: 'getAllTimes');
    }
}
