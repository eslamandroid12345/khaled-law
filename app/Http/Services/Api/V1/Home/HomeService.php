<?php

namespace App\Http\Services\Api\V1\Home;

use App\Http\Controllers\Api\V1\Structure\HomeController;
use App\Http\Controllers\Dashboard\Structure\HomeStructureController;
use App\Http\Resources\V1\Lawyer\LawyerResource;
use App\Http\Resources\V1\LegalForm\LegalFormResource;
use App\Http\Resources\V1\Service\ServiceGeneralResource;
use App\Http\Resources\V1\Service\ServiceResource;
use App\Http\Resources\V1\Service\ServiceSearchResource;
use App\Http\Resources\V1\User\UserSearchResource;
use App\Http\Resources\V1\Uses\usesResource;
use App\Http\Resources\V1\Lawyer\LawyerCollection;
use App\Http\Services\Api\V1\Structure\StructureService;
use App\Http\Services\Mutual\GetService;
use App\Http\Traits\Responser;
use App\Models\CustomerReview;
use App\Repository\CustomerReviewRepositoryInterface;
use App\Repository\LegalFormRepositoryInterface;
use App\Repository\ServiceRepositoryInterface;
use App\Repository\StructureRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Repository\UsesRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\V1\CustomerReview\CustomerReviewResource;

class HomeService
{
    use Responser;

    public function __construct(
        private readonly CustomerReviewRepositoryInterface    $customerreviewRepository,
        private readonly UserRepositoryInterface $userRepository,
        private readonly UsesRepositoryInterface $usesRepository ,
        private readonly LegalFormRepositoryInterface $legalFormRepository,
        private readonly ServiceRepositoryInterface $serviceRepository,
        private readonly StructureRepositoryInterface $structureRepository,
        private readonly StructureService             $structureService,
        private readonly GetService      $getService,
    )
    {
    }

    public function index()
    {
        $customer_reviews = CustomerReviewResource::collection($this->customerreviewRepository->getAllCustomerReviews());
        $lawyers = LawyerResource::collection($this->userRepository->getAllLawyersHome());
        $uses = UsesResource::collection($this->usesRepository->getAllUses());
        $legal_forms = LegalFormResource::collection($this->legalFormRepository->getAllLegalFormsHome());
        $services = ServiceGeneralResource::collection($this->serviceRepository->getAllServicesmsHome());
        $home_structure = $this->structureService->get('home',data_needed: true) ?? null;
        return $this->responseSuccess(data: [
            'home_structure' => $home_structure,
            'services' => $services,
            'legal_forms' => $legal_forms,
            'uses' => $uses,
            'lawyers' => $lawyers,
            'customer_reviews' => $customer_reviews,
        ]);
    }

    public function search()
    {
        $lawyers=UserSearchResource::collection($this->userRepository->getAllLawyersSearch());
        $services=ServiceSearchResource::collection($this->serviceRepository->getAllServiceSearch());
        return $this->responseSuccess(data: [
            'lawyers' => $lawyers ,
            'services' => $services ,
        ]);
    }

}
