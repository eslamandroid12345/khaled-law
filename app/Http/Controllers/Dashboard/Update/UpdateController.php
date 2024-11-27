<?php

namespace App\Http\Controllers\Dashboard\Update;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Update\UpdateRequest;
use App\Http\Services\Dashboard\Update\UpdateService;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    public function __construct(
        private readonly UpdateService $service
    )
    {
        $this->middleware('check_permission:updates-create')->only('create','store');
        $this->middleware('check_permission:updates-delete')->only('destroy');
    }

    public function store($id, UpdateRequest $request)
    {
        return $this->service->store($id, $request);
    }

    public function destroy($id)
    {
        return $this->service->destroy($id);
    }
}
