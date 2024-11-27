<?php

namespace App\Repository\Eloquent;

use App\Models\Appointment;
use App\Repository\AppointmentRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class AppointmentRepository extends Repository implements AppointmentRepositoryInterface
{
    public function __construct(Appointment $model)
    {
        parent::__construct($model);
    }

    public function getMyAppointments()
    {
        $query = $this->model::query();

        $query->whereHas('appointmentable', function ($q) {
            $q->where('lawyer_id', auth('api')->id());
        });

        if (request('day') != null) {
            $query->whereDate('date', request('day'));
            return $query->get();
        } else {
            $query->whereDate('date', Carbon::now()->format('Y-m-d'));
            return $query->limit(5)->get();
        }

    }
}
