<?php

namespace App\Http\Services\Dashboard\Service;
use App\Repository\CategoryRepositoryInterface;
use App\Repository\CustomerReviewRepositoryInterface;
use App\Repository\ImageRepositoryInterface;
use App\Repository\ServiceRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Services\Mutual\FileManagerService;
use Illuminate\Support\Facades\DB;

class ServiceService
{
    public function __construct(
        private readonly ServiceRepositoryInterface $serviceRepository,
        private readonly CategoryRepositoryInterface $categoryRepository,
        private readonly FileManagerService  $fileManagerService,
        private readonly ImageRepositoryInterface $imageRepository,
    )
    {
    }

    public function index()
    {
        $services = $this->serviceRepository->getAllServicesDashboard(10);
        return view('dashboard.site.service.index', compact('services'));
    }

    public function create()
    {
        $categories = $this->categoryRepository->getAll();
        return view('dashboard.site.service.create',compact('categories'));
    }

    public function store($request)
    {
        try
        {
            DB::beginTransaction();
            $data = $request->except('image');
            $service = $this->serviceRepository->create($data);
            if($request->hasFile('image'))
            {
                $this->uploadImage($request->image, $service);
            }
            DB::commit();
            return redirect()->route('services.index')->with(['success' => __('messages.created_successfully')]);
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return back()->with(['error' => __('messages.Something went wrong')]);
        }
    }

    public function show($id)
    {
        $service = $this->serviceRepository->getById($id);
        return view('dashboard.site.service.show', compact('service'));
    }
    public function edit($id)
    {
        $service = $this->serviceRepository->getById($id);
        $categories = $this->categoryRepository->getAll();
        return view('dashboard.site.service.edit', compact('service','categories'));
    }

    public function uploadImage($image, $service)
    {
        if ($image)
        {
            $newImage = $this->fileManagerService->handle("image", "services/images");
            $photo = $this->imageRepository->make(['path' => $newImage]);
            $service->image()->save($photo);
        }
    }

    public function deleteImage($service)
    {
        $service->image()->delete();
    }

    public function update($request, $id)
    {
        try
        {
            DB::beginTransaction();
            $service = $this->serviceRepository->getById($id);
            $data = $request->except('image');
            $this->serviceRepository->update($id, $data);
            if($request->hasFile('image'))
            {
                $this->deleteImage($service);
                $this->uploadImage($request->image, $service);
            }
            DB::commit();
            return redirect()->route('services.index')->with(['success' => __('messages.updated_successfully')]);
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
            $this->serviceRepository->delete($id);
            return redirect()->back()->with(['success' => __('messages.deleted_successfully')]);
        }
        catch (\Exception $e)
        {
            return back()->with(['error' => __('messages.Something went wrong')]);
        }
    }
}
