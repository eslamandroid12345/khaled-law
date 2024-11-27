<?php

namespace App\Models;

use App\Http\Enums\UserTypeEnum;
use App\Http\Traits\LanguageToggle;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Payment extends Model
{
    use HasFactory, LanguageToggle;

    const CHECKED = 1;

    protected $guarded = [];

    public function dueDateValue(): Attribute
    {
        return Attribute::make(get: function () {
            Carbon::setLocale(app()->getLocale());
            if ($this->transaction?->count() > 0 && auth('api')->user()?->type == UserTypeEnum::USER->value)
                return __('dashboard.paid_at') . $this->transaction?->createdAtFormat;
            else if ($this->due_date != null && auth('api')->user()?->type == UserTypeEnum::USER->value)
                return __('dashboard.payment_due_by') . Carbon::parse($this->due_date)->translatedFormat('l - j F g:i A');
            return null;
        });
    }
    public function dueDateValueDashboard(): Attribute
    {
        return Attribute::make(get: function () {
            Carbon::setLocale(app()->getLocale());
            if ($this->transaction?->count() > 0 )
                return __('dashboard.paid_at') . $this->transaction?->createdAtFormat;
            else if ($this->due_date != null )
                return __('dashboard.payment_due_by') . Carbon::parse($this->due_date)->translatedFormat('l - j F g:i A');
            return null;
        });
    }

    public function paymentServiceName(): Attribute
    {
        return Attribute::make(get: fn() => $this->order?->service?->t('name') . ' - #' . $this->order_id);
    }

    public function isPaid(): Attribute
    {
        return Attribute::make(get: fn() => $this->transaction?->count() > 0);
    }

    public function transaction(): MorphOne
    {
        return $this->morphOne(Transaction::class, 'transactionable');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }


}
