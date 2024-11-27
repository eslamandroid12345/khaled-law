<?php

namespace App\Http\Controllers\Dashboard\Attachment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Attachment\AttachmentRequest;
use App\Http\Services\Dashboard\Attachment\AttachmentService;
use Illuminate\Http\Request;

class AttachmentController extends Controller
{
    public function __construct(
        private readonly AttachmentService $service
    )
    {
        $this->middleware('check_permission:attachments-create')->only('create','store');
        $this->middleware('check_permission:attachments-delete')->only('destroy');
    }

    public function store($id, AttachmentRequest $request)
    {
        return $this->service->store($id, $request);
    }

    public function destroy($id)
    {
        return $this->service->destroy($id);
    }

}
