<?php

namespace App\Models;

use App\Http\Enums\OrderDataTypeEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function firstAppointmentDate(): Attribute
    {
        return Attribute::make(
            get: fn() => Carbon::parse($this->firstAppointment()?->first()?->date)->format('d/m/Y'));
    }

    public function dataTypeValue(): Attribute
    {
        return Attribute::make(
            get: fn() => OrderDataTypeEnum::fromName($this->data_type)->t());
    }

    public function orderName(): Attribute
    {
        return Attribute::make(get: fn() => $this->service?->t('name') . ' - #' . $this->id);
    }

    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachmentable')->latest();
    }

    public function appointments(): MorphMany
    {
        return $this->morphMany(Appointment::class, 'appointmentable')->latest();
    }

    public function firstAppointment()
    {
        return $this->morphMany(Appointment::class, 'appointmentable')->where('date', '>', Carbon::now())->orderBy('date')->limit(1);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lawyer()
    {
        return $this->belongsTo(User::class, 'lawyer_id');
    }

    public function updates()
    {
        return $this->hasMany(Update::class)->orderBy('date');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }


    public function chatroom()
    {
        return $this->hasOne(ChatRoom::class);
    }

    public function otherParty()
    {
        return $this->hasOneThrough(ChatRoomMember::class, ChatRoom::class)
            ->whereNot('user_id', auth('api')->id());
    }
    public function myParty()
    {
        return $this->hasOneThrough(ChatRoomMember::class, ChatRoom::class)
            ->where('user_id', auth('api')->id());
    }
}
