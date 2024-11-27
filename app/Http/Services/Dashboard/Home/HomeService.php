<?php

namespace App\Http\Services\Dashboard\Home;

use App\Http\Enums\UserTypeEnum;
use App\Repository\CategoryRepositoryInterface;
use App\Repository\ConsultationRepositoryInterface;
use App\Repository\LegalFormRepositoryInterface;
use App\Repository\ManagerRepositoryInterface;
use App\Repository\OrderRepositoryInterface;
use App\Repository\ServiceRepositoryInterface;
use App\Repository\UserRepositoryInterface;

class HomeService
{

    public function __construct(
        private readonly UserRepositoryInterface $userRepository ,
        private readonly CategoryRepositoryInterface $categoryRepository ,
        private readonly ServiceRepositoryInterface $serviceRepository ,
        private readonly OrderRepositoryInterface $orderRepository ,
        private readonly LegalFormRepositoryInterface $legalFormRepository ,
        private readonly ConsultationRepositoryInterface $consultationRepository ,
        private readonly ManagerRepositoryInterface $managerRepository ,
    ){

    }
    public function index()
    {
        $data = [
            'users' => $this->userRepository->count(['type' => UserTypeEnum::USER->value]),
            'lawyers' => $this->userRepository->count(['type' => UserTypeEnum::LAWYER->value]),
            'categories' => $this->categoryRepository->count(),
            'services' => $this->serviceRepository->count(),
            'orders' => $this->orderRepository->count(),
            'legalforms' => $this->legalFormRepository->count(),
            'consultations' => $this->consultationRepository->count(),
            'managers' => $this->managerRepository->count(),
        ];
        $orders=$this->orderRepository->getLatestOrdersDashboard();
        return view('dashboard.site.home.index',compact(['data','orders']));
    }
}
