<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Appointment extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function hourFormat(): Attribute
    {
        return Attribute::make(get: function () {
            return Carbon::parse($this->date)->format('g:i A');
        });
    }

    public function dateFormat(): Attribute
    {
        return Attribute::make(get: function () {
            Carbon::setLocale(app()->getLocale());
            return Carbon::parse($this->date)->translatedFormat('l - j F');
        });
    }

    public function appointmentTitle(): Attribute
    {
        Carbon::setLocale(app()->getLocale());
        return Attribute::make(get: fn() => __('website.You have ') . ' ' . $this->title . ' ' . __('website.at') . ' ' . Carbon::parse($this->date)->translatedFormat('h a - l j F'));
    }

    public function appointmentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function consultation()
    {
        return $this->morphTo('appointmentable', 'appointmentable_type', 'appointmentable_id')->where('appointmentable_type', 'App\Models\Consultation');
    }

}
