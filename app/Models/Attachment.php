<?php

namespace App\Models;

use App\Http\Enums\AttachmentTypeEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Cache;

class Attachment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function iconUrl(): Attribute
    {
        return Attribute::make(get: function () {
            if ($this->path != null && $this->type == AttachmentTypeEnum::FILE->value)
                return Cache::rememberForever('file_icon', fn() => url('storage/file_icon.png'));
            if ($this->path != null && $this->type == AttachmentTypeEnum::IMAGE->value)
                return url($this->path);
            return null;
        });
    }

    public function url(): Attribute
    {
        return Attribute::make(get: function () {
            if ($this->path != null)
                return url($this->path);
            return null;
        });
    }
    public function createdAtFormat(): Attribute
    {
        return Attribute::make(get: function () {
            Carbon::setLocale(app()->getLocale());
            return Carbon::parse($this->created_at)->translatedFormat('D j M - g:i A');
        });
    }


    public function attachmentable(): MorphTo
    {
        return $this->morphTo();
    }
}
