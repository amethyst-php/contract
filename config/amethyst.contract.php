<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Managers
    |--------------------------------------------------------------------------
    |
    | Here you can change the table name and the class components
    | used by each manager.
    |
    */
    'managers' => [
        'contract' => [
            /*
            |--------------------------------------------------------------------------
            | Table Name
            |--------------------------------------------------------------------------
            |
            | This is the table name used while interacting with the database
            |
            */
            'table' => 'amethyst_contracts',

            /*
            |--------------------------------------------------------------------------
            | Class Entity
            |--------------------------------------------------------------------------
            |
            | The class of the model used by the manager.
            | Change this if you have to add more relations or custom logic.
            |
            */
            'model' => Railken\Amethyst\Models\Contract::class,

            /*
            |--------------------------------------------------------------------------
            | Class Schema
            |--------------------------------------------------------------------------
            |
            | The class of the schema used by the manager.
            | Change this if you want to update the attributes.
            */
            'schema' => Railken\Amethyst\Schemas\ContractSchema::class,

            /*
            |--------------------------------------------------------------------------
            | Class Repository
            |--------------------------------------------------------------------------
            |
            | The class of the repository used to perform all queries.
            | Change this if you have to add more complex queries (e.g. ::findOneBy).
            |
            */
            'repository' => Railken\Amethyst\Repositories\ContractRepository::class,

            /*
            |--------------------------------------------------------------------------
            | Class Serializer
            |--------------------------------------------------------------------------
            |
            | The class of the serializer used to serialize the model.
            | Change this if you have to add more data while serializing.
            |
            */
            'serializer' => Railken\Amethyst\Serializers\ContractSerializer::class,

            /*
            |--------------------------------------------------------------------------
            | Class Validator
            |--------------------------------------------------------------------------
            |
            | The class of the validator used to validate the parameters.
            | Change this if you have to add more complex validation.
            | A validation handled by the single attributes is always preferred to this.
            |
            */
            'validator' => Railken\Amethyst\Validators\ContractValidator::class,

            /*
            |--------------------------------------------------------------------------
            | Class Authorizer
            |--------------------------------------------------------------------------
            |
            | The class of the authorizer used to authorize the user.
            | Change this if you have to add more complex authorization.
            |
            */
            'authorizer' => Railken\Amethyst\Authorizers\ContractAuthorizer::class,

            'payment_methods' => ['iban'],
        ],
        'contract-product' => [
            /*
            |--------------------------------------------------------------------------
            | Table Name
            |--------------------------------------------------------------------------
            |
            | This is the table name used while interacting with the database
            |
            */
            'table' => 'amethyst_contract_products',

            /*
            |--------------------------------------------------------------------------
            | Class Entity
            |--------------------------------------------------------------------------
            |
            | The class of the model used by the manager.
            | Change this if you have to add more relations or custom logic.
            |
            */
            'model' => Railken\Amethyst\Models\ContractProduct::class,

            /*
            |--------------------------------------------------------------------------
            | Class Schema
            |--------------------------------------------------------------------------
            |
            | The class of the schema used by the manager.
            | Change this if you want to update the attributes.
            */
            'schema' => Railken\Amethyst\Schemas\ContractProductSchema::class,

            /*
            |--------------------------------------------------------------------------
            | Class Repository
            |--------------------------------------------------------------------------
            |
            | The class of the repository used to perform all queries.
            | Change this if you have to add more complex queries (e.g. ::findOneBy).
            |
            */
            'repository' => Railken\Amethyst\Repositories\ContractProductRepository::class,

            /*
            |--------------------------------------------------------------------------
            | Class Serializer
            |--------------------------------------------------------------------------
            |
            | The class of the serializer used to serialize the model.
            | Change this if you have to add more data while serializing.
            |
            */
            'serializer' => Railken\Amethyst\Serializers\ContractProductSerializer::class,

            /*
            |--------------------------------------------------------------------------
            | Class Validator
            |--------------------------------------------------------------------------
            |
            | The class of the validator used to validate the parameters.
            | Change this if you have to add more complex validation.
            | A validation handled by the single attributes is always preferred to this.
            |
            */
            'validator' => Railken\Amethyst\Validators\ContractProductValidator::class,

            /*
            |--------------------------------------------------------------------------
            | Class Authorizer
            |--------------------------------------------------------------------------
            |
            | The class of the authorizer used to authorize the user.
            | Change this if you have to add more complex authorization.
            |
            */
            'authorizer' => Railken\Amethyst\Authorizers\ContractProductAuthorizer::class,
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
