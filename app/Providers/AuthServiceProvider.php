<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Http\Enums\OrderStatusEnum;
use App\Http\Enums\UserTypeEnum;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('access-order', function (User $user, $order) {
            return $user->type == UserTypeEnum::USER->value && $user->id == $order->user_id ||
                $user->type == UserTypeEnum::LAWYER->value && $user->id == $order->lawyer_id;
        });
        Gate::define('cannot-store-review', function (User $user, $order) {
            return $order->status != OrderStatusEnum::FINISHED->value ||
                $order->user_id != auth('api')->id() ||
                $order->reviews?->count() > 0;
        });
        Gate::define('access-room', function ($user, $room) {
            return $room->members?->contains('user_id', auth('api')->id()) && $room->status == 'OPEN';
        });
    }
}
