<?php

namespace App\Repository;

interface TransactionRepositoryInterface extends RepositoryInterface
{
    public function getAllLegaFormForUser();
    public function getAllTransactionDashboard($perPage);

}
