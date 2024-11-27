<?php

namespace App\Repository\Eloquent;

use App\Models\LegalFormOrder;
use App\Repository\LegalFormOrderRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class LegalFormOrderRepository extends Repository implements LegalFormOrderRepositoryInterface
{
    public function __construct(LegalFormOrder $model)
    {
        parent::__construct($model);
    }

    public function getLegalFormOrdersByLegalFormId($legalFormId)
    {
        return $this->model::query()->where('user_id',auth()->user()->id)->where('legal_form_id',$legalFormId)->get();
    }

    public function checkOrder($legalFormId)
    {
        return $this->model::query()->where('user_id',auth()->user()->id)->where('legal_form_id',$legalFormId)->exists();
    }

}
