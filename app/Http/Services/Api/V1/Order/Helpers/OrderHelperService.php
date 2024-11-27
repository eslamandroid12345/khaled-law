<?php

namespace App\Http\Services\Api\V1\Order\Helpers;

use App\Http\Services\Mutual\FileManagerService;
use App\Repository\ChatRoomRepositoryInterface;
use App\Repository\PaymentRepositoryInterface;
use App\Repository\ServiceRepositoryInterface;

class OrderHelperService
{
    public function __construct(
        private readonly ServiceRepositoryInterface  $serviceRepository,
        private readonly ChatRoomRepositoryInterface $chatRoomRepository,
        private readonly FileManagerService          $fileManagerService,
    )
    {

    }

    public function attachAttachments($order, $attachments)
    {
        if (is_array($attachments) && !empty($attachments)) {
            $data = [];
            foreach ($attachments as $attachment) {
                $data = [
                    'title' => $attachment['file']->getClientOriginalName(),
                    'type' => $attachment['type'],
                    'path' => $this->fileManagerService->uploadFile($attachment['file'], 'attachments'),
                ];
                $order->attachments()?->create($data);
            }
        }
    }

    public function attachFirstPayment($service_id , &$order)
    {
        $service = $this->serviceRepository->getById($service_id, ['id', 'price']);
        if ($service->price != null)
            $order->payments()?->create([
                'name_ar' => 'الدفعه الاولي',
                'name_en' => 'First payment',
                'price' => $service->price,
            ]);
    }

    public function startChat($order)
    {
        $this->chatRoomRepository->provide($order->lawyer_id, $order->id);
    }

}
