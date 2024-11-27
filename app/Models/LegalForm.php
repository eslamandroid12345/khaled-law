<?php

namespace App\Models;

use App\Http\Traits\LanguageToggle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class LegalForm extends Model
{
    use HasFactory,LanguageToggle;

    protected $table = 'legal_forms';
    protected $guarded = [];

    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function transactions(): MorphOne
    {
        return $this->morphOne(Transaction::class, 'transactionable');
    }

    public function legalFormOrders()
    {
        return $this->hasMany(LegalFormOrder::class);
    }
}
