<?php

return [
    'table' => 'ore_contracts',

    'attributes' => [
    ],

    'payment_methods' => [
        'iban',
    ],

    /*
    |--------------------------------------------------------------------------
    | Http configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure the routes
    |
    */
    'http' => [
        'admin' => [
            'enabled'    => true,
            'controller' => Railken\LaraOre\Http\Controllers\Admin\ContractsController::class,
            'router'     => [
                'prefix'      => '/admin/contracts',
            ],
        ],
    ],
];
