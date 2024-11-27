<?php

namespace App\Repository;

interface ImageRepositoryInterface extends RepositoryInterface
{
    public function make(array $attributes);
}
