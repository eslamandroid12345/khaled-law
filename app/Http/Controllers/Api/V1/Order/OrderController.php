<?php

namespace App\Http\Controllers\Api\V1\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Order\OrderRequest;
use App\Http\Requests\Api\V1\Order\OrderReviewRequest;
use App\Http\Services\Api\V1\Order\OrderService;
use http\Env\Request;

class OrderController extends Controller
{
    public function __construct(
        private readonly OrderService $service
    )
    {
        $this->middleware('type:USER')->only(['index', 'store']);
    }

    public function index()
    {
        return $this->service->index();
    }
    public function show($id)
    {
        return $this->service->show($id);
    }

    public function store(OrderRequest $request)
    {
        return $this->service->store($request);
    }
    public function storeReview(OrderReviewRequest $request)
    {
        return $this->service->storeReview($request);
    }
}
