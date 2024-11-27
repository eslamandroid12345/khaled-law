<?php

namespace App\Http\Controllers\Dashboard\Question;

use App\Http\Controllers\Controller;
use App\Http\Requests\Question\QuestionRequest;
use App\Http\Services\Dashboard\Question\QuestionService;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function __construct(private readonly QuestionService $service)
    {
        $this->middleware('check_permission:questions-read')->only('index');
        $this->middleware('check_permission:questions-create')->only('create','store');
        $this->middleware('check_permission:questions-update')->only('edit','update');
        $this->middleware('check_permission:questions-delete')->only('destroy');
    }

    public function index($id)
    {
        return $this->service->index($id);
    }

    public function show($id)
    {
        return $this->service->show($id);
    }

    public function create($id)
    {
        return $this->service->create($id);
    }

    public function store(QuestionRequest $request)
    {
        return $this->service->store($request);
    }

    public function edit(string $id)
    {
        return $this->service->edit($id);
    }

    public function update(QuestionRequest $request, string $id)
    {
        return $this->service->update($request, $id);
    }

    public function destroy(string $id)
    {
        return $this->service->destroy($id);
    }

}
