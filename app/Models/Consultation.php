<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Consultation extends Model
{
    use HasFactory;

    protected $table = 'consultations';

    protected $guarded = [];

    public function getFormattedDateAttribute()
    {
        $carbonDate = Carbon::parse($this->appointments?->date);
        Carbon::setLocale(app()->getLocale()); // Set the locale to Arabic
        return $carbonDate->translatedFormat('l j F'); // e.g., "الثلاثاء 6 اغسطس"
    }

    // Accessor for the formatted time (12-hour format with AM/PM)
    public function getFormattedTimeAttribute()
    {
        $carbonDate = Carbon::parse($this->appointments?->date);
        return $carbonDate->format('g:i A'); // e.g., "3:00 PM"
    }

    public function getFormattedDateAt()
    {
        return Carbon::parse($this->appointments?->date)->format('d/m/Y'); // e.g., 25/9/2024
    }

    public function getIsNewAttribute()
    {
        // Check if $this->appointments->meet_link is not null
        if ($this->appointments && $this->appointments->meeting_link !== null)
        {
            return __('website.old');
        }
        return __('website.new');
    }

    public function getKeyIsNewAttribute()
    {
        // Check if $this->appointments->meet_link is not null
        if ($this->appointments && $this->appointments->meeting_link !== null)
        {
            return "OLD";
        }
        return "NEW";
    }

    public function typeValue() : Attribute
    {
        return Attribute::get(function () {
            if($this->type == 'OFFLINE')
                return __('website.offline');
            else
                return __('website.online');
        });
    }

    public function caseValue() : Attribute
    {
        return Attribute::get(function () {
            if($this->case == 'NEW')
                return __('website.NEW');
            elseif($this->case == 'UNDER_REVIEW')
                return __('website.UNDER_REVIEW');
            else
                return __('website.FINISHED');
        });
    }

    public function statusValue() : Attribute
    {
        return Attribute::get(function ()
        {
            if($this->status == 'PAIED')
                return __('website.paied');
            else
                return __('website.unpaied');
        });
    }

    public function transactions(): MorphOne
    {
        return $this->morphOne(Transaction::class, 'transactionable');
    }

    public function appointments(): MorphOne
    {
        return $this->morphOne(Appointment::class, 'appointmentable');
    }

    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachmentable');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function lawyer()
    {
        return $this->belongsTo(User::class,'lawyer_id');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
