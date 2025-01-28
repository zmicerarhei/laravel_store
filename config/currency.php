<?php

return [
    'default' => [
        'iso' => 'BYN',
        'sale_rate' => 1.0,
    ],

    'api_url' => env('CURRENCY_API_URL', 'https://bankdabrabyt.by/export_courses.php'),
    'currencies' => explode(',', env('CURRENCY_LIST', 'USD,EUR,RUB')),
];
