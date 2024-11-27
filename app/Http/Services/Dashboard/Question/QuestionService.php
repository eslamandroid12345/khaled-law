<?php

namespace App\Http\Services\Dashboard\Question;

use App\Repository\QuestionRepositoryInterface;
use Illuminate\Support\Facades\DB;

class QuestionService
{
    public function __construct(
        private readonly QuestionRepositoryInterface $questionRepository,
    )
    {
    }

    public function index($id)
    {
        $questions = $this->questionRepository->getServiceQuestionsDashboard($id);
        $service_id=$id;
        return view('dashboard.site.questions.index', compact(['questions','service_id']));
    }

    public function create($id)
    {
        $service_id=$id;
        return view('dashboard.site.questions.create',compact('service_id'));
    }

    public function store($request)
    {
        try
        {
            DB::beginTransaction();
            $data = $request->validated();
            $question = $this->questionRepository->create($data);
            DB::commit();
            return redirect()->route('questions.index',$question->service_id)->with(['success' => __('messages.created_successfully')]);
        }
        catch (\Exception $e)
        {
            DB::rollBack();
//            return $e;
            return back()->with(['error' => __('messages.Something went wrong')]);
        }
    }

    public function show($id)
    {
        $question = $this->questionRepository->getById($id);
        return view('dashboard.site.questions.show', compact('question'));
    }
    public function edit($id)
    {
        $question = $this->questionRepository->getById($id);
        return view('dashboard.site.questions.edit', compact('question'));
    }

    public function update($request, $id)
    {
        try
        {
            DB::beginTransaction();
            $question=$this->questionRepository->getById($id,['id','service_id']);
            $data = $request->validated();
            $this->questionRepository->update($id, $data);
            DB::commit();
            return redirect()->route('questions.index',$question->service_id)->with(['success' => __('messages.updated_successfully')]);
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
            $this->questionRepository->delete($id);
            return redirect()->back()->with(['success' => __('messages.deleted_successfully')]);
        }
        catch (\Exception $e)
        {
            return back()->with(['error' => __('messages.Something went wrong')]);
        }
    }
}
