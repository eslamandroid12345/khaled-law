<?php

namespace App\Repository;

interface QuestionRepositoryInterface extends RepositoryInterface
{
    public function getServiceQuestionsDashboard($id);
}
