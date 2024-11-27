<?php

namespace App\Http\Services\Api\V1\LegalForm;

use App\Http\Enums\UserTypeEnum;
use App\Http\Resources\V1\LegalForm\LegalFormCollection;
use App\Http\Resources\V1\LegalForm\LegalFormForUserCollection;
use App\Http\Resources\V1\LegalForm\LegalFormResource;
use App\Http\Resources\V1\LegalForm\LegalFormOrderResource;
use App\Http\Resources\V1\LegalForm\DownloadLegalFormResource;
use App\Http\Services\Mutual\FileManagerService;
use App\Http\Services\Mutual\GetService;
use App\Http\Services\PlatformService;
use App\Http\Traits\Responser;
use App\Repository\LegalFormRepositoryInterface;
use App\Repository\TransactionRepositoryInterface;
use App\Repository\LegalFormOrderRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

abstract class LegalFormService extends PlatformService
{
    use Responser;

    public function __construct(
        private readonly LegalFormRepositoryInterface $legalFormRepository,
        private readonly TransactionRepositoryInterface $transactionRepository,
        private readonly LegalFormOrderRepositoryInterface $legalFormOrderRepository,
        private readonly FileManagerService           $fileManagerService,
        private readonly GetService                   $getService,
    )
    {
    }

    public function index()
    {
        return $this->getService->handle(LegalFormCollection::class, $this->legalFormRepository, 'getAllLegalForm',is_instance: true);
    }

    public function show($id)
    {
        return $this->getService->handle(LegalFormResource::class, $this->legalFormRepository, 'getById',parameters: [$id],is_instance: true);
    }

    public function download($id)
    {
        
        $legal_form = $this->legalFormRepository->getById($id);
        $filePath = public_path($legal_form->file);
        return response()->download($filePath);
        // return $this->getService->handle(DownloadLegalFormResource::class, $this->legalFormRepository, 'getById',parameters: [$id],is_instance: true);
    }

    public function getAllLegaFormForUser()
    {
        return $this->getService->handle(LegalFormForUserCollection::class, $this->transactionRepository, 'getAllLegaFormForUser',parameters: [10],is_instance: true);
    }

    public function storeOrder($request)
    {
        DB::beginTransaction();
        try
        {
            $data = $request->validated();
            $check = $this->legalFormOrderRepository->checkOrder($request->legal_form_id);
            if($check)
            {
                $legal_froms = $this->legalFormOrderRepository->getLegalFormOrdersByLegalFormId($request->legal_form_id);
                foreach($legal_froms as $legal_from)
                {
                    $legal_from->delete();
                }
            }
            $data['user_id'] = auth()->user()->id;
            $legal_form_order = $this->legalFormOrderRepository->create($data);
            DB::commit();
            return $this->responseSuccess(message: __('messages.created_successfully'), data: new LegalFormOrderResource($legal_form_order, true));
        }
        catch (Exception $e)
        {
            DB::rollBack();
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function getOrder($id)
    {
        return $this->getService->handle(LegalFormOrderResource::class, $this->legalFormOrderRepository, 'getById',parameters: [$id],is_instance: true);
    }

}
