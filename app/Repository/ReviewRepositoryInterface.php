<?php

namespace App\Repository;

interface ReviewRepositoryInterface extends RepositoryInterface
{
//    public function getAllReviewForLawyer($perPage);
    public function getAllReviewForUser($perPage);
}
