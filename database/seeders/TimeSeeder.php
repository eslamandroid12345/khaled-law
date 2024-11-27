<?php

namespace Database\Seeders;

use App\Models\Manager;
use App\Models\Time;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $days_english = [
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday',
            'Sunday',
        ];

        $days_arabic = [
            'الأثنين',
            'الثلاثاء',
            'الأربعاء',
            'الخميس',
            'الجمعة',
            'السبت',
            'الأحد',
        ];

        $day_index = [1, 2, 3, 4, 5, 6, 7];

        foreach ($days_english as $index => $day) {
            Time::firstOrcreate(['day_index' => $day_index[$index]], [
                'day_index' => $day_index[$index],              // English day name
                'day_en' => $day,              // English day name
                'day_ar' => $days_arabic[$index], // Corresponding Arabic day name
                'from' => '09:00:00',        // Default start time
                'to' => '17:00:00',        // Default end time
            ]);
        }
    }
}
