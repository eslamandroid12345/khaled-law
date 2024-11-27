<?php

namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

trait StrLimit
{
    public function strL($name = '', $localized = false, $limit = 40)
    {
        $locale = $localized ? '_' . app()->getLocale() : '';
        $value = $this->{$name . $locale};
        if ($value !== null) {
            $unescapedString = strip_tags($value);
            return Str::limit($unescapedString, $limit);
        }
        return null;
    }
}
