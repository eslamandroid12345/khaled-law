<?php

namespace App\Http\Controllers\Api\V1\Update;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Update\UpdatesRequest;
use App\Http\Services\Api\V1\Update\UpdatesService;
use Illuminate\Http\Request;

class UpdatesController extends Controller
{
    public function __construct(
        private readonly UpdatesService $service
    )
    {
        $this->middleware('type:LAWYER')->only(['store']);
    }

    public function store(UpdatesRequest $request)
    {
        return $this->service->store($request);
    }
}
