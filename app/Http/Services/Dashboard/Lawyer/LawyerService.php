<?php

namespace App\Http\Services\Dashboard\Lawyer;
use App\Repository\ServiceRepositoryInterface;
use App\Repository\UserServiceRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Services\Mutual\FileManagerService;
use App\Repository\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class LawyerService
{
    public function __construct(
        private readonly UserRepositoryInterface $lawyerRepository,
        private readonly UserServiceRepositoryInterface $userserviceRepository,
        private readonly ServiceRepositoryInterface $serviceRepository,
        private readonly FileManagerService  $fileManagerService
    )
    {
    }

    public function index()
    {
        $lawyers = $this->lawyerRepository->getAllLawyers(10);
        return view('dashboard.site.lawyers.index', compact('lawyers'));
    }

    public function create()
    {
        $services = $this->serviceRepository->getAll();
        return view('dashboard.site.lawyers.create',compact('services'));
    }

    public function store($request)
    {
        try
        {
            DB::beginTransaction();
            $data = $request->validated();
            if ($request->hasFile('image'))
            {
                $data['image'] = $this->fileManagerService->handle("image", "lawyers");
            }
            $data['type'] = 'lawyer';
            $lawyer = $this->lawyerRepository->create($data);
            $this->storeService($lawyer,$request);
            DB::commit();
            return redirect()->route('lawyers.index')->with(['success' => __('messages.created_successfully')]);
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return back()->with(['error' => __('messages.Something went wrong')]);
        }
    }

    public function storeService($lawyer,$request)
    {
        foreach($request->services as $index => $service)
        {
            $this->userserviceRepository->create(['lawyer_id' => $lawyer->id,'service_id' => $request->services[$index]]);
        }
    }
    public function show($id)
    {
        $lawyer = $this->lawyerRepository->getById($id);
        return view('dashboard.site.lawyers.show', compact('lawyer'));
    }
    public function edit($id)
    {
        $lawyer = $this->lawyerRepository->getById($id);
        $services = $this->serviceRepository->getAll();
        return view('dashboard.site.lawyers.edit', compact('lawyer','services'));
    }

    public function update($request, $id)
    {
        try
        {
            DB::beginTransaction();
            $lawyer = $this->lawyerRepository->getById($id);
            $data = $request->validated();
            if ($request->hasFile('image'))
            {
                $data['image'] = $this->fileManagerService->handle("image", "lawyers");
            }
            $this->lawyerRepository->update($id, $data);
            $lawyer->services()->detach();
            $this->storeService($lawyer,$request);
            DB::commit();
            return redirect()->route('lawyers.index')->with(['success' => __('messages.updated_successfully')]);
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
            $this->lawyerRepository->delete($id);
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
            $lawyer = $this->lawyerRepository->getById($request->itemId);
            $lawyer->update(['is_active' => $request->status]);
            return response()->json(['success' => true]);
        }
        catch (\Exception $e)
        {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
