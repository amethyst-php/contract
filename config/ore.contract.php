<?php

return [

    'table' => 'ore_contracts',

    'attributes' => [

    ],

    'router' => [
        'prefix'      => '/admin/contracts',
        'middlewares' => [
            \Railken\LaraOre\RequestLoggerMiddleware::class,
            'auth:api',
        ],
    ],
];
