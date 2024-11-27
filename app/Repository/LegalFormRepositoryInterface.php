<?php

namespace App\Repository;

interface LegalFormRepositoryInterface extends RepositoryInterface
{
    public function getAllLegalForm();
    public function getAllLegalFormsDashboard($perPage);
    public function getAllLegalFormsHome();

}
