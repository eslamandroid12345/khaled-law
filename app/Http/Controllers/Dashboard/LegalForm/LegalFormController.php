<?php

namespace App\Http\Controllers\Dashboard\LegalForm;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\LegalForm\LegalFormRequest;
use App\Http\Services\Dashboard\LegalForm\LegalFormService;
use Illuminate\Http\Request;

class LegalFormController extends Controller
{
    public function __construct(private readonly LegalFormService $legalform)
    {
        $this->middleware('check_permission:legalforms-read')->only('index');
        $this->middleware('check_permission:legalforms-create')->only('create','store');
        $this->middleware('check_permission:legalforms-update')->only('edit','update');
        $this->middleware('check_permission:legalforms-delete')->only('destroy');
    }

    public function index()
    {
        return $this->legalform->index();
    }

    public function show($id)
    {
        return $this->legalform->show($id);
    }

    public function create()
    {
        return $this->legalform->create();
    }

    public function store(LegalFormRequest $request)
    {
        return $this->legalform->store($request);
    }

    public function edit(string $id)
    {
        return $this->legalform->edit($id);
    }

    public function update(LegalFormRequest $request, string $id)
    {
        return $this->legalform->update($request, $id);
    }

    public function destroy(string $id)
    {
        return $this->legalform->destroy($id);
    }

    public function toggle(Request $request)
    {
        return $this->legalform->toggle($request);
    }
}
