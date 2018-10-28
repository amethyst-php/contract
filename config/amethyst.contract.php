<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Data
    |--------------------------------------------------------------------------
    |
    | Here you can change the table name and the class components-
    |
    */
    'data' => [
        'contract' => [
            'table'           => 'amethyst_contracts',
            'comment'         => 'Contract',
            'model'           => Railken\Amethyst\Models\Contract::class,
            'schema'          => Railken\Amethyst\Schemas\ContractSchema::class,
            'repository'      => Railken\Amethyst\Repositories\ContractRepository::class,
            'serializer'      => Railken\Amethyst\Serializers\ContractSerializer::class,
            'validator'       => Railken\Amethyst\Validators\ContractValidator::class,
            'authorizer'      => Railken\Amethyst\Authorizers\ContractAuthorizer::class,
            'faker'           => Railken\Amethyst\Fakers\ContractFaker::class,
            'manager'         => Railken\Amethyst\Managers\ContractManager::class,
            'payment_methods' => ['iban'],
        ],
        'contract-product' => [
            'table'      => 'amethyst_contract_products',
            'comment'    => 'Contract Product',
            'model'      => Railken\Amethyst\Models\ContractProduct::class,
            'schema'     => Railken\Amethyst\Schemas\ContractProductSchema::class,
            'repository' => Railken\Amethyst\Repositories\ContractProductRepository::class,
            'serializer' => Railken\Amethyst\Serializers\ContractProductSerializer::class,
            'validator'  => Railken\Amethyst\Validators\ContractProductValidator::class,
            'authorizer' => Railken\Amethyst\Authorizers\ContractProductAuthorizer::class,
            'faker'      => Railken\Amethyst\Fakers\ContractProductFaker::class,
            'manager'    => Railken\Amethyst\Managers\ContractProductManager::class,
        ],
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
            'contract' => [
                'enabled'     => true,
                'controller'  => Railken\Amethyst\Http\Controllers\Admin\ContractsController::class,
                'router'      => [
                    'as'        => 'contract.',
                    'prefix'    => '/contracts',
                ],
            ],
            'contract-product' => [
                'enabled'     => true,
                'controller'  => Railken\Amethyst\Http\Controllers\Admin\ContractProductsController::class,
                'router'      => [
                    'as'        => 'contract-product.',
                    'prefix'    => '/contract-products',
                ],
            ],
        ],
    ],
];
