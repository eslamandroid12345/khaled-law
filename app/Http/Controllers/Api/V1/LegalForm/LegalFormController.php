<?php

namespace App\Http\Controllers\Api\V1\LegalForm;

use App\Http\Requests\Api\V1\LegalFormOrder\LegalFormOrderRequest;
use App\Http\Controllers\Controller;
use App\Http\Services\Api\V1\LegalForm\LegalFormService;

class LegalFormController extends Controller
{
    public function __construct(
        private readonly LegalFormService $legalForm,
    )
    {
        $this->middleware('auth:api')->only('getAllLegaFormForUser','storeOrder');
    }

    public function index()
    {
        return $this->legalForm->index();
    }
    public function show($id)
    {
        return $this->legalForm->show($id);
    }

    public function download($id)
    {
        return $this->legalForm->download($id);
    }

    public function getAllLegaFormForUser()
    {
        return $this->legalForm->getAllLegaFormForUser();
    }

    public function storeOrder(LegalFormOrderRequest $request)
    {
        return $this->legalForm->storeOrder($request);
    }

    public function getOrder($id)
    {
        return $this->legalForm->getOrder($id);
    }
}
