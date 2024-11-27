<?php

namespace App\Http\Services\Api\V1\Category;

use App\Http\Resources\V1\Category\CategoryResource;
use App\Http\Services\Mutual\GetService;
use App\Repository\CategoryRepositoryInterface;

class CategoryService
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository ,
        private readonly GetService $get ,
    ){

    }
    public function index()
    {
        return $this->get->handle(CategoryResource::class,$this->categoryRepository,'getAll');
    }
}
