<?php

namespace App\Http\Controllers\Api\V1\Structure;

use App\Http\Controllers\Controller;
use App\Http\Services\Api\V1\Structure\StructureService;
use App\Http\Traits\Responser;
use Illuminate\Http\Request;

class HeaderFooterController extends StructureController
{
    use Responser;

    protected string $contentKey = 'header-footer';

    public function __construct(StructureService $structureService,
    )
    {
        parent::__construct($structureService);
    }

}
