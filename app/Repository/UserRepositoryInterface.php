<?php

namespace App\Repository;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function getActiveUsers();
    public function getAllUsers($perPage);
    public function getAllLawyers($perPage);
    public function getAllListLawyers();
    public function getAllLawyersWebsite();
    public function countLawyers();
    public function getAllLawyersHome();
    public function getAllLawyersSearch();
    public function getUserDetails($id);
    public function checkItem($byColumn, $value);
}
