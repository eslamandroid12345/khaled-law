<?php

namespace App\Repository\Eloquent;

use App\Models\Appointment;
use App\Models\Time;
use App\Models\Consultation;
use App\Repository\AppointmentRepositoryInterface;
use App\Repository\TimeRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class TimeRepository extends Repository implements TimeRepositoryInterface
{
    public function __construct(Time $model)
    {
        parent::__construct($model);
    }

    public function isActiveForConsultation($hour,$date)
    {
        $timeHour = Carbon::parse($hour)->format('H:i:s');
        $parsedDate = Carbon::parse($date)->format('Y-m-d'); // Ensure the date is properly formatted

        return Appointment::where('appointmentable_type', 'App\Models\Consultation')
            ->whereTime('date', '=', $timeHour) // Compare only the time part
            ->whereDate('date', $parsedDate) // Compare only the date part
            // ->with('consultation')
            ->whereHasMorph('appointmentable', [Consultation::class], function ($query) {
                $query->where('case', '!=', 'FINISHED'); // Check if the Consultation case is 'finished'
            })
            ->exists();
    }

    public function getAllTimes()
    {
        $timeRecord = $this->model::query()->where('is_active',true)->where('day_index', request('day_index'))->first();
        $date = request('date');
        if ($timeRecord)
        {
            $from = Carbon::parse($timeRecord->from);
            $to = Carbon::parse($timeRecord->to);
            $times = [];
            while ($from->lte($to))
            {
                $times[] = [
                    'hour' => $from->format('h:i A'),
                    'is_active' => !$this->isActiveForConsultation($from->format('h:i'),$date)?? 0,
                ];
                $from->addHour();
            }
            return $times;
        }
        else
        {
            return [];
        }
    }
}
