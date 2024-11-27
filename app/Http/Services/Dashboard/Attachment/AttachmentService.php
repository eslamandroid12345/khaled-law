<?php

namespace App\Http\Services\Dashboard\Attachment;

use App\Http\Enums\AttachmentTypeEnum;
use App\Http\Requests\Dashboard\Attachment\AttachmentRequest;
use App\Http\Services\Mutual\FileManagerService;
use App\Models\Order;
use App\Repository\AttachmentRepositoryInterface;
use App\Repository\OrderRepositoryInterface;
use Illuminate\Support\Facades\DB;

class AttachmentService
{
    public function __construct(
        private readonly FileManagerService            $fileManagerService,
        private readonly OrderRepositoryInterface      $repository,
        private readonly AttachmentRepositoryInterface $attachmentRepository,
    )
    {

    }

    public function store($id, AttachmentRequest $request)
    {
        try {
            DB::beginTransaction();
            $order = $this->repository->getById($id, ['id']);
            if (is_array($request->attachments) && !empty($request->attachments)) {
                $data = [];
                foreach ($request->attachments as $attachment) {
                    $data = [
                        'title' => $attachment->getClientOriginalName(),
                        'type' => $this->checkAttachmentType($attachment),
                        'path' => $this->fileManagerService->uploadFile($attachment, 'attachments'),
                    ];
                    $order->attachments()?->create($data);
                }
            }
            DB::commit();
            return redirect()->back()->with(['success' => __('messages.created_successfully')]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    private function checkAttachmentType($file)
    {
        $imageMimeTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/svg+xml'];
        $mimeType = $file->getMimeType();
        if (in_array($mimeType, $imageMimeTypes)) {
            return AttachmentTypeEnum::IMAGE->value;
        } else {
            return AttachmentTypeEnum::FILE->value;
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $attachment = $this->attachmentRepository->getById($id, ['id', 'path']);
            if ($attachment->path != null && file_exists($attachment->path))
            {
                unlink($attachment->path);
            }
            $attachment?->delete();
            DB::commit();
            return redirect()->back()->with(['success' => __('messages.deleted_successfully')]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


}
