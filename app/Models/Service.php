<?php

namespace App\Models;

use App\Http\Traits\LanguageToggle;
use App\Http\Traits\StrLimit;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Service extends Model
{
    use HasFactory, StrLimit, LanguageToggle;

    protected $guarded = [];

    public function priceTitle(): Attribute
    {
        return Attribute::make(get: fn() => $this->price ? $this->price . ' ' . __('messages.SR') : '');
    }

    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function lawyers()
    {
        return $this->belongsToMany(User::class, 'user_services', 'service_id', 'lawyer_id');
    }

    public function reviews()
    {
        return $this->hasManyThrough(Review::class, Order::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
