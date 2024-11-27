<?php

namespace App\Repository\Eloquent;

use App\Models\Attachment;
use App\Repository\AttachmentRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class AttachmentRepository extends Repository implements AttachmentRepositoryInterface
{
    public function __construct(Attachment $model)
    {
        parent::__construct($model);
    }
}
