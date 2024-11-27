<?php

namespace App\Http\Controllers\Api\V1\Lawyer;

use App\Http\Controllers\Controller;
use App\Http\Services\Api\V1\Lawyer\LawyerService;
use App\Http\Services\Api\V1\LegalForm\LegalFormService;

class LawyerController extends Controller
{
    public function __construct(
        private readonly LawyerService $lawyerForm,
    )
    {
        //$this->middleware('auth:api');
    }

    public function index()
    {
        return $this->lawyerForm->index();
    }
    public function show($id)
    {
        return $this->lawyerForm->show($id);
    }
}
