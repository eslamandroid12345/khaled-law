<?php

namespace App\Http\Services\Api\V1\Uses;

use App\Http\Resources\V1\Uses\UsesResource;
use App\Http\Services\Mutual\GetService;
use App\Repository\UsesRepositoryInterface;
use Carbon\Carbon;

class UsesService
{

    public function __construct(
        private readonly GetService $get ,
        private readonly UsesRepositoryInterface $usesRepository ,
    )
    {

    }

    public function index()
    {
        return $this->get->handle(UsesResource::class,$this->usesRepository,method: 'getAllUses');
    }
}
