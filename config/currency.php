<?php

return [
    'default' => [
        'iso' => 'BYN',
        'sale_rate' => 1.0,
    ],

    'api_url' => env('CURRENCY_API_URL', 'https://bankdabrabyt.by/export_courses.php'),
    'currencies' => array_filter(explode(',', (string) env('CURRENCY_LIST', 'USD,EUR,RUB'))),
    'fallbackRates' => [
        [
            'iso' => 'USD',
            'sale' => '3.35',
        ],
        [
            'iso' => 'EUR',
            'sale' => '3.55',
        ],
        [
            'iso' => 'RUB',
            'sale' => '0.0350',
        ],
    ],
];
