<?php

namespace App\Http\Controllers\Dashboard\Time;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Time\TimeRequest;
use App\Http\Services\Dashboard\Time\TimeService;
use Illuminate\Http\Request;

class TimeController extends Controller
{
    public function __construct(private readonly TimeService $time)
    {
        $this->middleware('check_permission:times-update')->only('edit','update');
    }

    public function index()
    {
        return $this->time->index();
    }

    public function show($id)
    {
        return $this->time->show($id);
    }

    public function edit(string $id)
    {
        return $this->time->edit($id);
    }

    public function update(TimeRequest $request, string $id)
    {
        return $this->time->update($request, $id);
    }

    public function toggleTime(Request $request)
    {
        return $this->time->toggleTime($request);
    }

}
