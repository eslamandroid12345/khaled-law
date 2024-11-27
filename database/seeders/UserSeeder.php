<?php

namespace Database\Seeders;

use App\Http\Enums\UserTypeEnum;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->firstOrCreate([
            'email' => 'user@elryad.com',
        ], [
            'name' => 'User',
            'email' => 'user@elryad.com',
            'password' => 'elryad1256!#',
        ]);
        User::query()->firstOrCreate([
            'email' => 'lawyer@elryad.com',
        ], [
            'name' => 'Lawyer',
            'type' => UserTypeEnum::LAWYER->value,
            'email' => 'lawyer@elryad.com',
            'password' => 'elryad1256!#',
        ]);
    }
}
