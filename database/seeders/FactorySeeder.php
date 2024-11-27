<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Consultation;
use App\Models\LegalForm;
use App\Models\Question;
use App\Models\Review;
use App\Models\Service;
use App\Models\User;
use App\Models\CustomerReview;
use App\Models\Uses;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FactorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::factory()->count(10)->create();
        User::factory()->count(20)->create();
        Service::factory()->count(30)->create();
//        Review::factory()->count(20)->create();
        Question::factory()->count(20)->create();
        Consultation::factory()->count(20)->create();
        LegalForm::factory()->count(20)->create();
        CustomerReview::factory()->count(20)->create();
        Uses::factory()->count(20)->create();

    }
}
