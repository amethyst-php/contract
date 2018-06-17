<?php

return [

    'table' => 'ore_contracts',

    'attributes' => [

    ],

    'payment_methods' => [
        'iban',
    ],

    'router' => [
        'prefix'      => '/admin/contracts',
        'middlewares' => [
            \Railken\LaraOre\RequestLoggerMiddleware::class,
            'auth:api',
        ],
    ],
];
