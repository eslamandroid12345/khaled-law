<?php

namespace Database\Seeders;

use App\Models\Manager;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $manager = Manager::query()->firstOrCreate(
            [
                'email' => 'admin@khaled.com',
            ]
            , [
            'name' => 'Admin',
            'email' => 'admin@khaled.com',
            'phone' => '+96650000000',
            'password' => '123123123'
        ]);
        $manager->addRole(1);
    }
}
