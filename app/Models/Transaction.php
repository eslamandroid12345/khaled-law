<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function getStatusAttribute()
    {
        return $this->attributes['status'] == 0
            ? trans('dashboard.not_payed')
            : trans('dashboard.payed');
    }
    public function createdAtFormat(): Attribute
    {
        return Attribute::make(get: function () {
            Carbon::setLocale(app()->getLocale());
            return Carbon::parse($this->created_at)->translatedFormat('l - j F g:i A');
        });
    }

    public function getTypeBuyAttribute()
    {
        // Example logic for type attribute
        if ($this->attributes['transactionable_type'] == 'App\Models\LegalForm')
        {
            return trans('dashboard.legal_form_pay');
        }
        else
        {
            return trans('dashboard.consultation_pay');
        }
    }

    public function transactionable(): MorphTo
    {
        return $this->morphTo();
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }


}
