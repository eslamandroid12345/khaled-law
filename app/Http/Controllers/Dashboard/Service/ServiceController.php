<?php

namespace App\Http\Controllers\Dashboard\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Service\ServiceRequest;
use App\Http\Services\Dashboard\Service\ServiceService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function __construct(private readonly ServiceService $service)
    {
        $this->middleware('check_permission:services-read')->only('index');
        $this->middleware('check_permission:services-create')->only('create','store');
        $this->middleware('check_permission:services-update')->only('edit','update');
        $this->middleware('check_permission:services-delete')->only('destroy');
    }

    public function index()
    {
        return $this->service->index();
    }

    public function show($id)
    {
        return $this->service->show($id);
    }

    public function create()
    {
        return $this->service->create();
    }

    public function store(ServiceRequest $request)
    {
        return $this->service->store($request);
    }

    public function edit(string $id)
    {
        return $this->service->edit($id);
    }

    public function update(ServiceRequest $request, string $id)
    {
        return $this->service->update($request, $id);
    }

    public function destroy(string $id)
    {
        return $this->service->destroy($id);
    }

}
