<?php

namespace Database\Seeders;

use App\Models\Info;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Info::query()->updateOrCreate(['key' => 'price_online'], [
            'key' => 'price_online',
            'type' => 'text',
            'name_en' => 'Price Online',
            'name_ar' => 'سعر الاستشارة الاونلاين',
        ]);
        Info::query()->updateOrCreate(['key' => 'price_offline'], [
            'key' => 'price_offline',
            'type' => 'text',
            'name_en' => 'Price Offline',
            'name_ar' => 'سعر الاستشارة الحضورية',
        ]);

        Info::query()->updateOrCreate(['key' => 'image_consultation'], [
            'key' => 'image_consultation',
            'type' => 'image',
            'name_en' => 'Image Consultation',
            'name_ar' => 'صورة الاستشارة',
        ]);
    }
}
