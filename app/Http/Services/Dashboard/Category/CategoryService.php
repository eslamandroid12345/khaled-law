<?php

namespace App\Http\Services\Dashboard\Category;
use App\Repository\CategoryRepositoryInterface;
use App\Repository\ImageRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Services\Mutual\FileManagerService;
use Illuminate\Support\Facades\DB;

class CategoryService
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository,
        private readonly FileManagerService  $fileManagerService,
        private readonly ImageRepositoryInterface $imageRepository,
    )
    {
    }

    public function index()
    {
        $categories = $this->categoryRepository->getAllCategoriesDashboard(10);
        return view('dashboard.site.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('dashboard.site.categories.create');
    }

    public function store($request)
    {
        try
        {
            DB::beginTransaction();
            $data = $request->validated();
            $category = $this->categoryRepository->create($data);
            DB::commit();
            return redirect()->route('categories.index')->with(['success' => __('messages.created_successfully')]);
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return back()->with(['error' => __('messages.Something went wrong')]);
        }
    }

    public function show($id)
    {
        $category = $this->categoryRepository->getById($id);
        return view('dashboard.site.categories.show', compact('category'));
    }
    public function edit($id)
    {
        $category = $this->categoryRepository->getById($id);
        return view('dashboard.site.categories.edit', compact('category'));
    }

    public function update($request, $id)
    {
        try
        {
            DB::beginTransaction();
            $category = $this->categoryRepository->getById($id);
            $data = $request->validated();
            $this->categoryRepository->update($id, $data);
            DB::commit();
            return redirect()->route('categories.index')->with(['success' => __('messages.updated_successfully')]);
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return back()->with(['error' => __('messages.Something went wrong')]);
        }
    }

    public function destroy($id)
    {
        try
        {
            $this->categoryRepository->delete($id);
            return redirect()->back()->with(['success' => __('messages.deleted_successfully')]);
        }
        catch (\Exception $e)
        {
            return back()->with(['error' => __('messages.Something went wrong')]);
        }
    }
}
