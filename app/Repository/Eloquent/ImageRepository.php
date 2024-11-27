<?php

namespace App\Repository\Eloquent;

use App\Models\Image;
use App\Repository\ImageRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class ImageRepository extends Repository implements ImageRepositoryInterface
{
    protected Model $model;

    public function __construct(Image $model)
    {
        parent::__construct($model);
    }

    public function make(array $attributes)
    {
        return new Image($attributes);
    }

}
