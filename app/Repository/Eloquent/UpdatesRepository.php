<?php

namespace App\Repository\Eloquent;

use App\Models\Update;
use App\Repository\UpdatesRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class UpdatesRepository extends Repository implements UpdatesRepositoryInterface
{
    public function __construct(Update $model)
    {
        parent::__construct($model);
    }
}
