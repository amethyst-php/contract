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
            'table'      => 'amethyst_contracts',
            'comment'    => 'Contract',
            'model'      => Amethyst\Models\Contract::class,
            'schema'     => Amethyst\Schemas\ContractSchema::class,
            'repository' => Amethyst\Repositories\ContractRepository::class,
            'serializer' => Amethyst\Serializers\ContractSerializer::class,
            'validator'  => Amethyst\Validators\ContractValidator::class,
            'authorizer' => Amethyst\Authorizers\ContractAuthorizer::class,
            'faker'      => Amethyst\Fakers\ContractFaker::class,
            'manager'    => Amethyst\Managers\ContractManager::class,
            'attributes' => [
                'payment_methods' => [
                    'parent' => 'Payment Method',
                ],
            ],
        ],
        'contract-product' => [
            'table'          => 'amethyst_contract_products',
            'comment'        => 'Contract Product',
            'model'          => Amethyst\Models\ContractProduct::class,
            'schema'         => Amethyst\Schemas\ContractProductSchema::class,
            'repository'     => Amethyst\Repositories\ContractProductRepository::class,
            'serializer'     => Amethyst\Serializers\ContractProductSerializer::class,
            'validator'      => Amethyst\Validators\ContractProductValidator::class,
            'authorizer'     => Amethyst\Authorizers\ContractProductAuthorizer::class,
            'faker'          => Amethyst\Fakers\ContractProductFaker::class,
            'manager'        => Amethyst\Managers\ContractProductManager::class,
            'group-taxonomy' => 'contract-products',
        ],
        'contract-product-consume' => [
            'table'      => 'amethyst_contract_product_consumes',
            'comment'    => 'Consumed Product',
            'model'      => Amethyst\Models\ContractProductConsume::class,
            'schema'     => Amethyst\Schemas\ContractProductConsumeSchema::class,
            'repository' => Amethyst\Repositories\ContractProductConsumeRepository::class,
            'serializer' => Amethyst\Serializers\ContractProductConsumeSerializer::class,
            'validator'  => Amethyst\Validators\ContractProductConsumeValidator::class,
            'authorizer' => Amethyst\Authorizers\ContractProductConsumeAuthorizer::class,
            'faker'      => Amethyst\Fakers\ContractProductConsumeFaker::class,
            'manager'    => Amethyst\Managers\ContractProductConsumeManager::class,
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
                'enabled'    => true,
                'controller' => Amethyst\Http\Controllers\Admin\ContractsController::class,
                'router'     => [
                    'as'     => 'contract.',
                    'prefix' => '/contracts',
                ],
            ],
            'contract-product' => [
                'enabled'    => true,
                'controller' => Amethyst\Http\Controllers\Admin\ContractProductsController::class,
                'router'     => [
                    'as'     => 'contract-product.',
                    'prefix' => '/contract-products',
                ],
            ],
            'contract-product-consume' => [
                'enabled'    => true,
                'controller' => Amethyst\Http\Controllers\Admin\ContractProductConsumesController::class,
                'router'     => [
                    'as'     => 'contract-product-consume.',
                    'prefix' => '/contract-product-consumes',
                ],
            ],
        ],
    ],
];
