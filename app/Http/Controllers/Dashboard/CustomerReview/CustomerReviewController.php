<?php

namespace App\Http\Controllers\Dashboard\CustomerReview;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CustomerReview\CustomerReviewRequest;
use App\Http\Services\Dashboard\CustomerReview\CustomerReviewService;
use Illuminate\Http\Request;

class CustomerReviewController extends Controller
{
    public function __construct(private readonly CustomerReviewService $customerReview)
    {
        $this->middleware('check_permission:customer-review-read')->only('index');
        $this->middleware('check_permission:customer-review-create')->only('create','store');
        $this->middleware('check_permission:customer-review-update')->only('edit','update');
        $this->middleware('check_permission:customer-review-delete')->only('destroy');
    }

    public function index()
    {
        return $this->customerReview->index();
    }

    public function show($id)
    {
        return $this->customerReview->show($id);
    }

    public function create()
    {
        return $this->customerReview->create();
    }

    public function store(CustomerReviewRequest $request)
    {
        return $this->customerReview->store($request);
    }

    public function edit(string $id)
    {
        return $this->customerReview->edit($id);
    }

    public function update(CustomerReviewRequest $request, string $id)
    {
        return $this->customerReview->update($request, $id);
    }

    public function destroy(string $id)
    {
        return $this->customerReview->destroy($id);
    }

}
