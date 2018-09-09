<?php

return [
    'table' => 'ore_contract_services',

    'attributes' => [
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
            'controller' => Railken\LaraOre\Http\Controllers\Admin\ContractServicesController::class,
            'router'     => [
                'prefix'      => '/contract-services',
            ],
        ],
    ],
];
