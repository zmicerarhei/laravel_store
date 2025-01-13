<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        $services = [
            ['name' => 'Гарантийное обслуживание', 'duration' => 14, 'price' => 0.00],
            ['name' => 'Доставка', 'duration' => 3, 'price' => 25.00],
            ['name' => 'Установка', 'duration' => 5, 'price' => 75.00],
            ['name' => 'Настройка', 'duration' => 2, 'price' => 50.00],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
