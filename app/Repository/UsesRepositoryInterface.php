<?php

namespace App\Repository;

interface UsesRepositoryInterface extends RepositoryInterface
{
    public function getAllUsesDashboard($perPage);
    public function getAllUses();
}
