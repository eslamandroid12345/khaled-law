<?php

namespace App\Http\Controllers\Api\V1\Category;

use App\Http\Controllers\Controller;
use App\Http\Services\Api\V1\Category\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(
        private readonly CategoryService $service
    )
    {
//        $this->middleware('type:USER')->only(['index']);
    }

    public function index()
    {
        return $this->service->index();
    }
}
