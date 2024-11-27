<?php

namespace App\Http\Controllers\Api\V1\Attachment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Attachment\AttachmentRequest;
use App\Http\Services\Api\V1\Attachment\AttachmentService;
use Illuminate\Http\Request;

class AttachmentController extends Controller
{
    public function __construct(
        private readonly AttachmentService $service
    )
    {
//        $this->middleware('type:LAWYER')->only(['store']);
    }

    public function store(AttachmentRequest $request)
    {
        return $this->service->store($request);
    }
}
