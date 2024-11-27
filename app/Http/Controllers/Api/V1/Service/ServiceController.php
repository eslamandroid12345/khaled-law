<?php

namespace App\Http\Controllers\Api\V1\Service;

use App\Http\Controllers\Controller;
use App\Http\Services\Api\V1\Services\ServicesService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function __construct(
        private readonly ServicesService $service
    )
    {

    }

    public function index()
    {
        return $this->service->index();
    }
    public function show($id)
    {
        return $this->service->show($id);
    }
    public function breadcrumb($id)
    {
        return $this->service->breadcrumb($id);
    }
}
