<?php

namespace Railken\LaraOre\ContractService\Attributes\PriceStart;

use Railken\Laravel\Manager\Attributes\BaseAttribute;
use Railken\Laravel\Manager\Contracts\EntityContract;
use Railken\Laravel\Manager\Tokens;
use Respect\Validation\Validator as v;

class PriceStartAttribute extends BaseAttribute
{
    /**
     * Name attribute.
     *
     * @var string
     */
    protected $name = 'price_start';

    /**
     * Is the attribute required
     * This will throw not_defined exception for non defined value and non existent model.
     *
     * @var bool
     */
    protected $required = false;

    /**
     * Is the attribute unique.
     *
     * @var bool
     */
    protected $unique = false;

    /**
     * List of all exceptions used in validation.
     *
     * @var array
     */
    protected $exceptions = [
        Tokens::NOT_DEFINED    => Exceptions\ContractServicePriceStartNotDefinedException::class,
        Tokens::NOT_VALID      => Exceptions\ContractServicePriceStartNotValidException::class,
        Tokens::NOT_AUTHORIZED => Exceptions\ContractServicePriceStartNotAuthorizedException::class,
        Tokens::NOT_UNIQUE     => Exceptions\ContractServicePriceStartNotUniqueException::class,
    ];

    /**
     * List of all permissions.
     */
    protected $permissions = [
        Tokens::PERMISSION_FILL => 'contractservice.attributes.price_start.fill',
        Tokens::PERMISSION_SHOW => 'contractservice.attributes.price_start.show',
    ];

    /**
     * Is a value valid ?
     *
     * @param EntityContract $entity
     * @param mixed          $value
     *
     * @return bool
     */
    public function valid(EntityContract $entity, $value)
    {
        return v::numeric()->validate($value);
    }

    /**
     * Retrieve default value.
     *
     * @param EntityContract $entity
     *
     * @return mixed
     */
    public function getDefault(EntityContract $entity)
    {
        return $entity->service ? $entity->service->price_starting : null;
    }
}
