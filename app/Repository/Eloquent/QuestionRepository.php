<?php

namespace App\Repository\Eloquent;

use App\Models\Question;
use App\Repository\QuestionRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class QuestionRepository extends Repository implements QuestionRepositoryInterface
{
    public function __construct(Question $model)
    {
        parent::__construct($model);
    }

    public function getServiceQuestionsDashboard($id)
    {
        return $this->model::query()->where('service_id', $id)->get();
    }

}
