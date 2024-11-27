<?php

namespace App\Models;

use App\Http\Traits\LanguageToggle;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
    use HasFactory,LanguageToggle;

    protected $table = 'times';
    protected $guarded = [];

    public function getFormattedFromAttribute()
    {
        return Carbon::parse($this->attributes['from'])->format('h:i A');
    }

    // Custom accessor for 'formatted_to' attribute
    public function getFormattedToAttribute()
    {
        return Carbon::parse($this->attributes['to'])->format('h:i A');
    }
}
