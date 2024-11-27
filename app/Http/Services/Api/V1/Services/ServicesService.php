<?php

namespace App\Http\Services\Api\V1\Services;

use App\Http\Resources\V1\Service\ServiceBreadcrumbResource;
use App\Http\Resources\V1\Service\ServiceCollection;
use App\Http\Resources\V1\Service\ServiceGeneralResource;
use App\Http\Resources\V1\Service\ServiceResource;
use App\Http\Services\Mutual\GetService;
use App\Repository\ServiceRepositoryInterface;

class ServicesService
{

    public function __construct(
        private readonly GetService $get ,
        private readonly ServiceRepositoryInterface $serviceRepository ,
    )
    {

    }

    public function index()
    {
        return $this->get->handle(ServiceCollection::class,$this->serviceRepository,'paginateServices',[12],true);
    }
    public function show($id)
    {
        return $this->get->handle(ServiceResource::class,$this->serviceRepository,'getById',[$id , ['*'] , ['image','reviews.user','questions']],true);
    }
    public function breadcrumb($id)
    {
        return $this->get->handle(ServiceBreadcrumbResource::class,$this->serviceRepository,'getById',[$id , ['*'] , ['category']],true);
    }
}
