<?php

namespace App\Http\Services\Dashboard\Time;
use App\Repository\TimeRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Services\Mutual\FileManagerService;
use Illuminate\Support\Facades\DB;

class TimeService
{
    public function __construct(
        private readonly TimeRepositoryInterface $timeRepository,
        private readonly FileManagerService  $fileManagerService,
    )
    {
    }

    public function index()
    {
        $times = $this->timeRepository->paginate(15);
        return view('dashboard.site.times.index', compact('times'));
    }
    public function edit($id)
    {
        $time = $this->timeRepository->getById($id);
        return view('dashboard.site.times.edit', compact('time'));
    }

    public function update($request, $id)
    {
        try
        {
            DB::beginTransaction();
            $time = $this->timeRepository->getById($id);
            $data = $request->validated();
            $this->timeRepository->update($id, $data);
            DB::commit();
            return redirect()->route('time.index')->with(['success' => __('messages.updated_successfully')]);
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return back()->with(['error' => __('messages.Something went wrong')]);
        }
    }

    public function toggleTime($request)
    {
        try
        {
            $time = $this->timeRepository->getById($request->itemId);
            $this->timeRepository->update($time->id,['is_active' =>  $request->status]);
            return response()->json(['success' => true]);
        }
        catch (\Exception $e)
        {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
