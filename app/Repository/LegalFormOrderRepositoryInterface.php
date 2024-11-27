<?php

namespace App\Repository;

interface LegalFormOrderRepositoryInterface extends RepositoryInterface
{
    public function getLegalFormOrdersByLegalFormId($legalFormId);
    public function checkOrder($legalFormId);
}
