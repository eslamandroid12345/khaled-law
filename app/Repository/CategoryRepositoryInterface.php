<?php

namespace App\Repository;

interface CategoryRepositoryInterface extends RepositoryInterface
{
    public function getAllCategoriesDashboard($perPage);
}
