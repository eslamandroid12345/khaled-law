<?php

namespace App\Http\Services\Api\V1\Lawyer;

use App\Http\Resources\V1\Lawyer\LawyerCollection;
use App\Http\Resources\V1\Lawyer\LawyerResource;
use App\Http\Resources\V1\Lawyer\OneLawyerResource;
use App\Http\Services\Mutual\FileManagerService;
use App\Http\Services\Mutual\GetService;
use App\Http\Services\PlatformService;
use App\Http\Traits\Responser;
use App\Repository\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

abstract class LawyerService extends PlatformService
{
    use Responser;

    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly FileManagerService           $fileManagerService,
        private readonly GetService                   $getService,
    )
    {
    }

    public function index()
    {
        return $this->getService->handle(LawyerCollection::class, $this->userRepository, 'getAllLawyersWebsite',is_instance: true);
    }

    public function show($id)
    {
        return $this->getService->handle(OneLawyerResource::class, $this->userRepository, 'getOneLawyer',parameters: [$id],is_instance: true);
    }

}
