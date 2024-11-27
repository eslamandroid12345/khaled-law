<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Update extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function dayFormat(): Attribute
    {
        return Attribute::make(get: function () {
            return Carbon::parse($this->date )->format('d') ;
        });
    }
    public function monthFormat(): Attribute
    {
        return Attribute::make(get: function () {
            Carbon::setLocale(app()->getLocale());
            return Carbon::parse($this->date )->translatedFormat('M') ;
        });
    }
}
