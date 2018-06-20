<?php

return [

    'table' => 'ore_contract_services',

    'attributes' => [

    ],

    'router' => [
        'prefix'      => '/admin/contract-services',
        'middlewares' => [
            \Railken\LaraOre\RequestLoggerMiddleware::class,
            'auth:api',
        ],
    ],
];
