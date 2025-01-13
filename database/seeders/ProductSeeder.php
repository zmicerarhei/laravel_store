<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'name' => 'Телевизор Sony R11',
                'description' => 'Телевизор с высоким разрешением и смарт-функциями.',
                'manufacturer' => 'Sony',
                'release_date' => '2024-01-01',
                'price' => 99.99,
                'link' => '/images/product_1.jpg',
                'category_id' => 1,
            ],
            [
                'name' => 'Смартфон Huawei P20',
                'description' => 'Современный смартфон с мощным процессором и большим объемом памяти.',
                'manufacturer' => 'Huawei',
                'release_date' => '2024-01-02',
                'price' => 85.50,
                'link' => '/images/product_2.jpg',
                'category_id' => 2,
            ],
            [
                'name' => 'Смартфон Samsung S15',
                'description' => 'Современный смартфон с мощным процессором и большим объемом памяти.',
                'manufacturer' => 'Samsung',
                'release_date' => '2024-01-02',
                'price' => 85.50,
                'link' => '/images/product_2.jpg',
                'category_id' => 2,
            ],
            [
                'name' => 'Смартфон Samsunmg S14',
                'description' => 'Современный смартфон с мощным процессором и большим объемом памяти.',
                'manufacturer' => 'Samsung',
                'release_date' => '2024-01-02',
                'price' => 85.50,
                'link' => '/images/product_2.jpg',
                'category_id' => 2,
            ],
            [
                'name' => 'Телевизор Sony 2214',
                'description' => 'Телевизор с высоким разрешением и смарт-функциями.',
                'manufacturer' => 'Sony',
                'release_date' => '2024-01-03',
                'price' => 75.00,
                'link' => '/images/product_3.jpg',
                'category_id' => 1,
            ],
            [
                'name' => 'Ноутбук Apple Slim',
                'description' => 'Супер мощный ноутбук для работы и игр.',
                'manufacturer' => 'Apple',
                'release_date' => '2024-01-12',
                'price' => 49.99,
                'link' => '/images/product_4.jpg',
                'category_id' => 3,
            ],
            [
                'name' => 'Планшет Samsung 1521',
                'description' => 'Легкий и портативный планшет для работы и игр.',
                'manufacturer' => 'Samsung',
                'release_date' => '2024-01-05',
                'price' => 299.99,
                'link' => '/images/product_5.jpg',
                'category_id' => 2,
            ],
            [
                'name' => 'Холодильник LG 225',
                'description' => 'Современный двухкамерный холодильник',
                'manufacturer' => 'LG',
                'release_date' => '2024-01-06',
                'price' => 499.99,
                'link' => '/images/product_6.jpg',
                'category_id' => 1,
            ],
            [
                'name' => 'Пылесос Samsung 1882',
                'description' => 'Пылесос мощный с функцией мойки.',
                'manufacturer' => 'Samsung',
                'release_date' => '2024-01-07',
                'price' => 199.99,
                'link' => '/images/product_7.jpg',
                'category_id' => 1,
            ],
            [
                'name' => 'Микроволновая печь LG A8',
                'description' => 'Современная микроволновая печь с грилем.',
                'manufacturer' => 'LG',
                'release_date' => '2024-01-08',
                'price' => 150.00,
                'link' => '/images/product_8.jpg',
                'category_id' => 1,
            ],
            [
                'name' => 'Стиральная машина LG 1132',
                'description' => 'Автоматическая стиральная машина с функцией сушки.',
                'manufacturer' => 'LG',
                'release_date' => '2024-01-09',
                'price' => 400.00,
                'link' => '/images/product_9.jpg',
                'category_id' => 1,
            ],
            [
                'name' => 'Ноутбук Sony 2618',
                'description' => 'Мощный современный ноутбук с большим количеством памяти',
                'manufacturer' => 'Sony',
                'release_date' => '2024-01-10',
                'price' => 159.99,
                'link' => '/images/product_10.jpg',
                'category_id' => 3,
            ],
            [
                'name' => 'Игровая консоль Sony Playstation',
                'description' => 'Портативная игровая консоль с поддержкой облачного гейминга.',
                'manufacturer' => 'Sony',
                'release_date' => '2024-01-11',
                'price' => 299.99,
                'link' => '/images/product_1.jpg',
                'category_id' => 2,
            ],
            [
                'name' => 'Телевизор Samsung 2000',
                'description' => 'Новейший телевизор с качественной матрицей',
                'manufacturer' => 'Samsung',
                'release_date' => '2024-01-11',
                'price' => 99.99,
                'link' => '/images/product_2.jpg',
                'category_id' => 1,
            ],
            [
                'name' => 'Ноутбук Samsung 2115',
                'description' => 'Мощный современный ноутбук с большим количеством памяти',
                'manufacturer' => 'Samsung',
                'release_date' => '2024-01-10',
                'price' => 159.99,
                'link' => '/images/product_10.jpg',
                'category_id' => 2,
            ],
            [
                'name' => 'Компьютер Apple i7',
                'description' => 'Мощный современный компьютер с большим количеством памяти и хорошей видеокартой',
                'manufacturer' => 'Apple',
                'release_date' => '2024-01-10',
                'price' => 159.99,
                'link' => '/images/product_10.jpg',
                'category_id' => 3,
            ],
            [
                'name' => 'Стиральная машина Sony 1253',
                'description' => 'Автоматическая стиральная машина с функцией сушки.',
                'manufacturer' => 'Sony',
                'release_date' => '2024-01-09',
                'price' => 400.00,
                'link' => '/images/product_9.jpg',
                'category_id' => 1,
            ],
            [
                'name' => 'Игровая консоль Samsung 15',
                'description' => 'Портативная игровая консоль с поддержкой облачного гейминга.',
                'manufacturer' => 'Samsung',
                'release_date' => '2024-01-11',
                'price' => 299.99,
                'link' => '/images/product_1.jpg',
                'category_id' => 2,
            ],
            [
                'name' => 'Телевизор LG 18',
                'description' => 'Новейший телевизор с качественной матрицей',
                'manufacturer' => 'LG',
                'release_date' => '2024-01-11',
                'price' => 99.99,
                'link' => '/images/product_2.jpg',
                'category_id' => 1,
            ],
            [
                'name' => 'Ноутбук Apple New',
                'description' => 'Мощный современный ноутбук с большим количеством памяти',
                'manufacturer' => 'Apple',
                'release_date' => '2024-01-10',
                'price' => 159.99,
                'link' => '/images/product_10.jpg',
                'category_id' => 3,
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
