<?php

namespace App\Http\Controllers\Dashboard\Lawyer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Lawyer\LawyerRequest;
use App\Http\Services\Dashboard\Lawyer\LawyerService;
use Illuminate\Http\Request;

class LawyersController extends Controller
{
    public function __construct(private readonly LawyerService $lawyer)
    {
        $this->middleware('check_permission:lawyers-read')->only('index');
        $this->middleware('check_permission:lawyers-create')->only('create','store');
        $this->middleware('check_permission:lawyers-update')->only('edit','update','toggle');
        $this->middleware('check_permission:lawyers-delete')->only('destroy');
    }

    public function index()
    {
        return $this->lawyer->index();
    }

    public function show($id)
    {
        return $this->lawyer->show($id);
    }

    public function create()
    {
        return $this->lawyer->create();
    }

    public function store(LawyerRequest $request)
    {
        return $this->lawyer->store($request);
    }

    public function edit(string $id)
    {
        return $this->lawyer->edit($id);
    }

    public function update(LawyerRequest $request, string $id)
    {
        return $this->lawyer->update($request, $id);
    }

    public function destroy(string $id)
    {
        return $this->lawyer->destroy($id);
    }

    public function toggle(Request $request)
    {
        return $this->lawyer->toggle($request);
    }
}
