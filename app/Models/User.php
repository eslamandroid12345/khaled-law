<?php

namespace App\Models;

use App\Http\Traits\LanguageToggle;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\Scopes\ActiveUserScope;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, LanguageToggle;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
//    protected $fillable = [
//        'name',
//        'email',
//        'phone',
//        'image',
//        'password',
//    ];

    protected $guarded = [];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    // protected static function booted()
    // {
    //     static::addGlobalScope(new ActiveUserScope);
    // }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if ($value !== null) {
                    return url($value);
                }
                return null;
            }
        );
    }

    public function isVerified(): Attribute
    {
        return Attribute::make(get: fn() => !$this->otp()?->exists());
    }

    public function otpToken(): Attribute
    {
        return Attribute::make(get: fn() => $this->otp?->token);
    }

    public function token()
    {
        return JWTAuth::fromUser($this);
    }

    public function orderAppointments()
    {
        return $this->hasManyThrough(Appointment::class, Order::class, 'lawyer_id', 'appointmentable_id');
    }

    public function myLegalForms()
    {
        return $this->hasManyThrough(LegalForm::class, Transaction::class,'user_id','id');
    }

    public function consultationsAppointments()
    {
        return $this->hasOneThrough(Appointment::class, Consultation::class, 'lawyer_id', 'appointmentable_id');
    }

    public function otp()
    {
        return $this->hasOne(Otp::class);
    }

    public function consultationAsUser()
    {
        return $this->hasMany(Consultation::class, 'user_id');
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class, 'user_id');
    }

    public function consultationAsLawyer()
    {
        return $this->hasMany(Consultation::class, 'lawyer_id');
    }

    public function consultationAsLawyerCount()
    {
        return $this->consultationAsLawyer->count();
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'user_services', 'lawyer_id', 'service_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function lawyerOrders()
    {
        return $this->hasMany(Order::class, 'lawyer_id');
    }

    public function reviewAsLaywer()
    {
        return $this->hasMany(Review::class,'lawyer_id');
    }

    public function reviewAsUser()
    {
        return $this->hasMany(Review::class,'user_id');
    }
    public function payments()
    {
        return $this->hasManyThrough(Payment::class, Order::class );
    }

    public function legalFormOrders()
    {
        return $this->hasMany(LegalFormOrder::class);
    }
    public function chatRooms()
    {
        return $this->hasMany(ChatRoomMember::class, 'user_id');
    }

    public function chatRoomMessage()
    {
        return $this->hasMany(ChatRoomMessage::class, 'user_id');
    }


}
