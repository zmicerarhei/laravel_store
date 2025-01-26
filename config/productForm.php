<?php

return [
    'fields' => [
        'name' => [
            'label' => 'Название',
            'type' => 'text',
        ],
        'brand' => [
            'label' => 'Производитель',
            'type' => 'text',
        ],
        'link' => [
            'label' => 'Ссылка на изображение',
            'type' => 'text',
        ],
        'description' => [
            'label' => 'Описание',
            'type' => 'text',
        ],
        'release_date' => [
            'label' => 'Дата выпуска товара',
            'type' => 'date',
            'max' => date('Y-m-d'),
        ],
        'price' => [
            'label' => 'Цена (в BYN)',
            'type' => 'number',
            'min' => 0,
            'step' => 0.01,
        ],
    ],
];
