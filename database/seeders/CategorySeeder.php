<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'title' => 'Бытовая техника',
                'desc' => 'Нужная техника для домашних хлопот',
                'img' => 'home-appliances.jpg',
                'slug' => 'home-appliances'
            ],
            [
                'title' => 'Электроника',
                'desc' => 'Передовые технологии на службе у человека',
                'img' => 'electronics.jpg',
                'slug' => 'electronics'
            ],
            [
                'title' => 'Компьютеры',
                'desc' => 'Самые мощные и надежные компьютеры',
                'img' => 'computers.jpg',
                'slug' => 'computers'
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
