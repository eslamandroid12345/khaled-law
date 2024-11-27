<?php

namespace App\Http\Controllers\Dashboard\Uses;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Uses\UsesRequest;
use App\Http\Services\Dashboard\Uses\UsesService;
use Illuminate\Http\Request;

class UsesController extends Controller
{
    public function __construct(private readonly UsesService $uses)
    {
        $this->middleware('check_permission:uses-read')->only('index');
        $this->middleware('check_permission:uses-create')->only('create','store');
        $this->middleware('check_permission:uses-update')->only('edit','update');
        $this->middleware('check_permission:uses-delete')->only('destroy');
    }

    public function index()
    {
        return $this->uses->index();
    }

    public function show($id)
    {
        return $this->uses->show($id);
    }

    public function create()
    {
        return $this->uses->create();
    }

    public function store(UsesRequest $request)
    {
        return $this->uses->store($request);
    }

    public function edit(string $id)
    {
        return $this->uses->edit($id);
    }

    public function update(UsesRequest $request, string $id)
    {
        return $this->uses->update($request, $id);
    }

    public function destroy(string $id)
    {
        return $this->uses->destroy($id);
    }

}
