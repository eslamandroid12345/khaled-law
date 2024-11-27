<?php

namespace App\Http\Controllers\Dashboard\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Category\CategoryRequest;
use App\Http\Services\Dashboard\Category\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(private readonly CategoryService $category)
    {
        $this->middleware('check_permission:categories-read')->only('index');
        $this->middleware('check_permission:categories-create')->only('create','store');
        $this->middleware('check_permission:categories-update')->only('edit','update');
        $this->middleware('check_permission:categories-delete')->only('destroy');
    }

    public function index()
    {
        return $this->category->index();
    }

    public function show($id)
    {
        return $this->category->show($id);
    }

    public function create()
    {
        return $this->category->create();
    }

    public function store(CategoryRequest $request)
    {
        return $this->category->store($request);
    }

    public function edit(string $id)
    {
        return $this->category->edit($id);
    }

    public function update(CategoryRequest $request, string $id)
    {
        return $this->category->update($request, $id);
    }

    public function destroy(string $id)
    {
        return $this->category->destroy($id);
    }

}
