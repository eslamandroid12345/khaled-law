<?php

namespace App\Http\Controllers\Api\V1\Uses;

use App\Http\Controllers\Controller;
use App\Http\Services\Api\V1\Uses\UsesService;

class UsesController extends Controller
{
    public function __construct(
        private readonly UsesService $uses,
    )
    {
    }

    public function index()
    {
        return $this->uses->index();
    }

}
