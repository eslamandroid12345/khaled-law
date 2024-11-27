<?php

namespace App\Http\Services\Dashboard\LegalForm;
use App\Repository\ImageRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Services\Mutual\FileManagerService;
use App\Repository\LegalFormRepositoryInterface;
use Illuminate\Support\Facades\DB;

class LegalFormService
{
    public function __construct(
        private readonly LegalFormRepositoryInterface $legalFormRepository,
        private readonly FileManagerService  $fileManagerService,
        private readonly ImageRepositoryInterface $imageRepository,
    )
    {
    }

    public function index()
    {
        $legalforms = $this->legalFormRepository->getAllLegalFormsDashboard(10);
        return view('dashboard.site.legalforms.index', compact('legalforms'));
    }

    public function create()
    {
        return view('dashboard.site.legalforms.create');
    }

    public function store($request)
    {
        try
        {
            DB::beginTransaction();
            $data = $request->except('image');
            if ($request->hasFile('file'))
            {
                $data['file'] = $this->fileManagerService->handle("file", "legalform/images");
            }
            $legalform = $this->legalFormRepository->create($data);
            $this->uploadImage($request->image, $legalform);
            DB::commit();
            return redirect()->route('legal-forms.index')->with(['success' => __('messages.created_successfully')]);
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return $e;
            return back()->with(['error' => __('messages.Something went wrong')]);
        }
    }

    public function uploadImage($image, $legalform)
    {
        if ($image)
        {
            $newImage = $this->fileManagerService->handle("image", "legalform/images");
            $photo = $this->imageRepository->make(['path' => $newImage]);
            $legalform->image()->save($photo);
        }
    }

    public function deleteImage($legalform)
    {
        $legalform->image()->delete();
    }
    public function show($id)
    {
        $legalform = $this->legalFormRepository->getById($id);
        return view('dashboard.site.legalforms.show', compact('legalform'));
    }
    public function edit($id)
    {
        $legalform = $this->legalFormRepository->getById($id);
        return view('dashboard.site.legalforms.edit', compact('legalform'));
    }

    public function update($request, $id)
    {
        try
        {
            DB::beginTransaction();
            $legalform = $this->legalFormRepository->getById($id);
            $data = $request->except('image');
            if ($request->hasFile('file'))
            {
                $data['file'] = $this->fileManagerService->handle("file", "legalform/images");
            }
            $this->legalFormRepository->update($id, $data);
            if($request->image)
            {
                $this->deleteImage($legalform);
                $this->uploadImage($request->image, $legalform);
            }
            DB::commit();
            return redirect()->route('legal-forms.index')->with(['success' => __('messages.updated_successfully')]);
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
            $this->legalFormRepository->delete($id);
            return redirect()->back()->with(['success' => __('messages.deleted_successfully')]);
        }
        catch (\Exception $e)
        {
            return back()->with(['error' => __('messages.Something went wrong')]);
        }
    }

    public function toggle(Request $request)
    {
        try
        {
            $legalform = $this->legalFormRepository->getById($request->itemId);
            $legalform->update(['is_active' => $request->status]);
            return response()->json(['success' => true]);
        }
        catch (\Exception $e)
        {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
