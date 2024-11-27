<?php

namespace App\Providers;

use App\Repository\AppointmentRepositoryInterface;
use App\Repository\AttachmentRepositoryInterface;
use App\Repository\CategoryRepositoryInterface;
use App\Repository\ChatRoomMemberRepositoryInterface;
use App\Repository\ChatRoomMessageRepositoryInterface;
use App\Repository\ChatRoomRepositoryInterface;
use App\Repository\Eloquent\AppointmentRepository;
use App\Repository\Eloquent\AttachmentRepository;
use App\Repository\Eloquent\CategoryRepository;
use App\Repository\Eloquent\ChatRoomMemberRepository;
use App\Repository\Eloquent\ChatRoomMessageRepository;
use App\Repository\Eloquent\ChatRoomRepository;
use App\Repository\CustomerReviewRepositoryInterface;
use App\Repository\Eloquent\CustomerReviewRepository;
use App\Repository\Eloquent\InfoRepository;
use App\Repository\Eloquent\ManagerRepository;
use App\Repository\Eloquent\OrderRepository;
use App\Repository\Eloquent\OtpRepository;
use App\Repository\Eloquent\PaymentRepository;
use App\Repository\Eloquent\PermissionRepository;
use App\Repository\Eloquent\QuestionRepository;
use App\Repository\Eloquent\Repository;
use App\Repository\Eloquent\ReviewRepository;
use App\Repository\Eloquent\RoleRepository;
use App\Repository\Eloquent\ServiceRepository;
use App\Repository\Eloquent\SettingsRepository;
use App\Repository\Eloquent\StructureRepository;
use App\Repository\Eloquent\TimeRepository;
use App\Repository\Eloquent\TransactionRepository;
use App\Repository\Eloquent\UpdatesRepository;
use App\Repository\Eloquent\UserRepository;
use App\Repository\Eloquent\ConsultationRepository;
use App\Repository\Eloquent\ImageRepository;
use App\Repository\Eloquent\LegalFormRepository;
use App\Repository\Eloquent\LegalFormOrderRepository;
use App\Repository\Eloquent\UserServiceRepository;
use App\Repository\Eloquent\UsesRepository;

use App\Repository\LegalFormOrderRepositoryInterface;
use App\Repository\InfoRepositoryInterface;
use App\Repository\LegalFormRepositoryInterface;
use App\Repository\ImageRepositoryInterface;
use App\Repository\ConsultationRepositoryInterface;
use App\Repository\ManagerRepositoryInterface;
use App\Repository\OrderRepositoryInterface;
use App\Repository\OtpRepositoryInterface;
use App\Repository\PaymentRepositoryInterface;
use App\Repository\PermissionRepositoryInterface;
use App\Repository\QuestionRepositoryInterface;
use App\Repository\RepositoryInterface;
use App\Repository\ReviewRepositoryInterface;
use App\Repository\RoleRepositoryInterface;
use App\Repository\ServiceRepositoryInterface;
use App\Repository\SettingsRepositoryInterface;
use App\Repository\StructureRepositoryInterface;
use App\Repository\TimeRepositoryInterface;
use App\Repository\TransactionRepositoryInterface;
use App\Repository\UpdatesRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Repository\UserServiceRepositoryInterface;
use App\Repository\UsesRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(RepositoryInterface::class, Repository::class);
        $this->app->singleton(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(SettingsRepositoryInterface::class, SettingsRepository::class);
        $this->app->singleton(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->singleton(PermissionRepositoryInterface::class, PermissionRepository::class);
        $this->app->singleton(ManagerRepositoryInterface::class, ManagerRepository::class);
        $this->app->singleton(ConsultationRepositoryInterface::class, ConsultationRepository::class);
        $this->app->singleton(ImageRepositoryInterface::class, ImageRepository::class);
        $this->app->singleton(LegalFormRepositoryInterface::class, LegalFormRepository::class);
        $this->app->singleton(QuestionRepositoryInterface::class, QuestionRepository::class);
        $this->app->singleton(ServiceRepositoryInterface::class, ServiceRepository::class);
        $this->app->singleton(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->singleton(CustomerReviewRepositoryInterface::class, CustomerReviewRepository::class);
        $this->app->singleton(UserServiceRepositoryInterface::class, UserServiceRepository::class);
        $this->app->singleton(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->singleton(AttachmentRepositoryInterface::class, AttachmentRepository::class);
        $this->app->singleton(AppointmentRepositoryInterface::class, AppointmentRepository::class);
        $this->app->singleton(UpdatesRepositoryInterface::class, UpdatesRepository::class);
        $this->app->singleton(PaymentRepositoryInterface::class, PaymentRepository::class);
        $this->app->singleton(OtpRepositoryInterface::class, OtpRepository::class);
        $this->app->singleton(ChatRoomRepositoryInterface::class, ChatRoomRepository::class);
        $this->app->singleton(ChatRoomMemberRepositoryInterface::class, ChatRoomMemberRepository::class);
        $this->app->singleton(ChatRoomMessageRepositoryInterface::class, ChatRoomMessageRepository::class);
        $this->app->singleton(ReviewRepositoryInterface::class, ReviewRepository::class);
        $this->app->singleton(TransactionRepositoryInterface::class, TransactionRepository::class);
        $this->app->singleton(TimeRepositoryInterface::class, TimeRepository::class);
        $this->app->singleton(UsesRepositoryInterface::class, UsesRepository::class);
        $this->app->singleton(StructureRepositoryInterface::class, StructureRepository::class);
        $this->app->singleton(InfoRepositoryInterface::class, InfoRepository::class);
        $this->app->singleton(LegalFormOrderRepositoryInterface::class, LegalFormOrderRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
