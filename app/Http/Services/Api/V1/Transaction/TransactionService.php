<?php

namespace App\Http\Services\Api\V1\Transaction;

use App\Http\Services\Mutual\FileManagerService;
use App\Http\Services\Mutual\GetService;
use App\Http\Traits\Responser;
use App\Repository\ConsultationRepositoryInterface;
use App\Repository\LegalFormRepositoryInterface;
use App\Repository\TransactionRepositoryInterface;
use App\Repository\LegalFormOrderRepositoryInterface;
use Illuminate\Support\Facades\DB;

class TransactionService
{

    use Responser;
    public function __construct(
        private readonly GetService $get ,
        private readonly TransactionRepositoryInterface $transactionRepository ,
        private readonly ConsultationRepositoryInterface $consultationRepository ,
        private readonly LegalFormRepositoryInterface $legalFormRepository ,
        private readonly LegalFormOrderRepositoryInterface $legalFormOrderRepository,
        private readonly FileManagerService  $fileManagerService,
    )
    {

    }

    public function storeConsultation($request)
    {
        DB::beginTransaction();
        try
        {
            $data = $request->except('consultation_id');
            $data['user_id'] = auth()->user()->id;
            $consultation = $this->consultationRepository->getById($request->consultation_id);
            if($request->image)
            {
                $data['image'] = $this->fileManagerService->uploadFile($request->image, 'transaction');
                $data['status'] = false;
            }
            else
            {
                $data['status'] = true;
            }
            $consultation->transactions()->create($data);
            $this->consultationRepository->update($consultation->id,["status" => "PAIED"]);

            DB::commit();
            return $this->responseSuccess(message: __('messages.The reservation has been completed successfully. Please arrive on time.'));
        }
        catch (Exception $e)
        {
            DB::rollBack();
//             return $e;
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }


    public function storeLegalForm($request)
    {
        DB::beginTransaction();
        try
        {
            $data = $request->except('legal_form_id','legal_form_order_id');
            $data['user_id'] = auth()->user()->id;
            $lega_form = $this->legalFormRepository->getById($request->legal_form_id);
            $lega_form_order = $this->legalFormOrderRepository->getById($request->legal_form_order_id);
            $data['counter'] = $lega_form_order->counter;
            $data['price'] = $lega_form_order->counter * $lega_form->price;
            if($request->image)
            {
                $data['image'] = $this->fileManagerService->uploadFile($request->image, 'transaction');
                $data['status'] = false;
            }
            else
            {
                $data['status'] = true;
            }
            $lega_form->transactions()->create($data);
            $this->consultationRepository->update($lega_form->id,["status" => "PAIED"]);
            $legalFormOrders = $this->legalFormOrderRepository->getLegalFormOrdersByLegalFormId($lega_form->id);
            if($legalFormOrders)
            {
                foreach($legalFormOrders as $legalFormOrder)
                {
                    $legalFormOrder->delete();
                }
            }
            DB::commit();
            return $this->responseSuccess(message: __('messages.The reservation has been completed successfully. Please arrive on time.'));
        }
        catch (Exception $e)
        {
            DB::rollBack();
//             return $e;
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }
}
