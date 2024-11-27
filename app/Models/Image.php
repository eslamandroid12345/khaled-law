<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Image extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function imageUrl(): Attribute
    {
        return Attribute::make(get: function () {
            if ($this->path != null)
                return url($this->path);
            return null;
        });
    }

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}
