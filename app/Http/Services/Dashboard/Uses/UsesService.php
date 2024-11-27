<?php

namespace App\Http\Services\Dashboard\Uses;

use App\Repository\ImageRepositoryInterface;
use App\Repository\UsesRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Services\Mutual\FileManagerService;
use Illuminate\Support\Facades\DB;

class UsesService
{
    public function __construct(
        private readonly UsesRepositoryInterface $usesRepository,
        private readonly FileManagerService  $fileManagerService,
        private readonly ImageRepositoryInterface $imageRepository,
    )
    {
    }

    public function index()
    {
        $uses = $this->usesRepository->getAllUsesDashboard(10);
        return view('dashboard.site.uses.index', compact('uses'));
    }

    public function create()
    {
        return view('dashboard.site.uses.create');
    }

    public function store($request)
    {
        try
        {
            DB::beginTransaction();
            $data = $request->except('image');
            $use = $this->usesRepository->create($data);
            $this->uploadImage($request->image, $use);
            DB::commit();
            return redirect()->route('uses.index')->with(['success' => __('messages.created_successfully')]);
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return back()->with(['error' => __('messages.Something went wrong')]);
        }
    }

    public function uploadImage($image, $use)
    {
        if ($image)
        {
            $newImage = $this->fileManagerService->handle("image", "uses/images");
            $photo = $this->imageRepository->make(['path' => $newImage]);
            $use->image()->save($photo);
        }
    }

    public function deleteImage($use)
    {
        $use->image()->delete();
    }
    public function show($id)
    {
        $use = $this->usesRepository->getById($id);
        return view('dashboard.site.uses.show', compact('use'));
    }
    public function edit($id)
    {
        $use = $this->usesRepository->getById($id);
        return view('dashboard.site.uses.edit', compact('use'));
    }

    public function update($request, $id)
    {
        try
        {
            DB::beginTransaction();
            $use = $this->usesRepository->getById($id);
            $data = $request->except('image');
            $this->usesRepository->update($id, $data);
            if($request->image)
            {
                $this->deleteImage($use);
                $this->uploadImage($request->image, $use);
            }
            DB::commit();
            return redirect()->route('uses.index')->with(['success' => __('messages.updated_successfully')]);
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
            $this->usesRepository->delete($id);
            return redirect()->back()->with(['success' => __('messages.deleted_successfully')]);
        }
        catch (\Exception $e)
        {
            return back()->with(['error' => __('messages.Something went wrong')]);
        }
    }
}
