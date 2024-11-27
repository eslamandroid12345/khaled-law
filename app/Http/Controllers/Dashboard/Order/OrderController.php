<?php

namespace App\Http\Controllers\Dashboard\Order;

use App\Http\Controllers\Controller;
use App\Http\Services\Dashboard\Order\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(private readonly OrderService $service)
    {
    }

    public function index()
    {
        return $this->service->index();
    }

    public function show($id)
    {
        return $this->service->show($id);
    }

    public function destroy(string $id)
    {
        return $this->service->destroy($id);
    }

    public function changeLawyer($order)
    {
        return $this->service->changeLawyer($order);
    }

    public function changeStatus($order)
    {
        return $this->service->changeStatus($order);
    }
    public function chat($order)
    {
        return $this->service->chat($order);
    }

}
