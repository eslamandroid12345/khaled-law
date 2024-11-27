<?php

namespace App\Repository\Eloquent;

use App\Models\UserService;
use App\Repository\UserServiceRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class UserServiceRepository extends Repository implements UserServiceRepositoryInterface
{
    public function __construct(UserService $model)
    {
        parent::__construct($model);
    }
}
