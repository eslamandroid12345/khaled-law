<?php

namespace App\Providers;

use App\Http\Services\Api\V1\Auth\AuthMobileService;
use App\Http\Services\Api\V1\Auth\AuthService;
use App\Http\Services\Api\V1\Auth\AuthWebService;
use App\Http\Services\Api\V1\Consultation\ConsultationMobileService;
use App\Http\Services\Api\V1\Consultation\ConsultationService;
use App\Http\Services\Api\V1\Consultation\ConsultationWebService;
use App\Http\Services\Api\V1\CustomerReview\CustomerReviewMobileService;
use App\Http\Services\Api\V1\CustomerReview\CustomerReviewService;
use App\Http\Services\Api\V1\CustomerReview\CustomerReviewWebService;
use App\Http\Services\Api\V1\Lawyer\LawyerMobileService;
use App\Http\Services\Api\V1\Lawyer\LawyerService;
use App\Http\Services\Api\V1\Lawyer\LawyerWebService;
use App\Http\Services\Api\V1\LegalForm\LegalFormMobileService;
use App\Http\Services\Api\V1\LegalForm\LegalFormService;
use App\Http\Services\Api\V1\LegalForm\LegalFormWebService;


use Illuminate\Support\ServiceProvider;

class PlatformServiceProvider extends ServiceProvider
{
    private const VERSIONS = [1];
    private const PLATFORMS = ['website', 'mobile'];
    private const DEFAULT_VERSION = 1;
    private const DEFAULT_PLATFORM = 'website';
    private const SERVICES = [
        1 => [
            AuthService::class => [
                AuthWebService::class,
                AuthMobileService::class
            ],
            ConsultationService::class => [
                ConsultationWebService::class,
                ConsultationMobileService::class
            ],
            LegalFormService::class => [
                LegalFormWebService::class,
                LegalFormMobileService::class
            ],
            CustomerReviewService::class => [
                CustomerReviewWebService::class,
                CustomerReviewMobileService::class
            ],
            LawyerService::class => [
                LawyerWebService::class,
                LawyerMobileService::class
            ],
        ],
    ];
    private ?int $version;
    private ?string $platform;

    public function __construct($app)
    {
        parent::__construct($app);

        foreach (self::VERSIONS as $version) {
            foreach (self::PLATFORMS as $platform) {
                $pattern = app()->isProduction()
                    ? "v$version/$platform/*"
                    : "api/v$version/$platform/*";

                if (request()->is($pattern)) {
                    $this->version = $version;
                    $this->platform = $platform;
                    return;
                }
            }
        }

        $this->version = self::DEFAULT_VERSION;
        $this->platform = self::DEFAULT_PLATFORM;
    }

    private function getTargetService(array $services)
    {
        foreach ($services as $service) {
            if ($service::platform() == $this->platform) {
                return $service;
            }
        }

        return $services[0];
    }

    private function initiate(): void
    {
        $services = self::SERVICES[$this->version] ?? [];

        foreach ($services as $abstractService => $targetServices) {
            $this->app->singleton($abstractService, $this->getTargetService($targetServices));
        }
    }

    public function register(): void
    {
        $this->initiate();
    }

    public function boot(): void
    {
        //
    }
}
