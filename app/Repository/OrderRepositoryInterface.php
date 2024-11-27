<?php

namespace App\Repository;

interface OrderRepositoryInterface extends RepositoryInterface
{
    public function paginateCustomerOrders($paginate);

    public function paginateLawyerOrders($paginate);

    public function paginateAllOrdersDashboard($paginate);
    public function getLatestOrdersDashboard();
}
