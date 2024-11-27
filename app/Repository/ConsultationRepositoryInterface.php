<?php

namespace App\Repository;

interface ConsultationRepositoryInterface extends RepositoryInterface
{
    public function getAllConsultationsDashboard($perPage);
    public function getAllConsultationsForUser($perPage);
    public function getAllConsultationsForLawyer($perPage);
}
