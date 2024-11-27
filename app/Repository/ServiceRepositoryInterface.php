<?php

namespace App\Repository;

interface ServiceRepositoryInterface extends RepositoryInterface
{
    public function paginateServices($paginate);
    public function getAllServicesDashboard();
    public function getAllServicesmsHome();
    public function getAllServiceSearch();
}
