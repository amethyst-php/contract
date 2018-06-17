<?php

namespace Railken\LaraOre\Contract\Attributes\PriceStart;

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
        Tokens::NOT_DEFINED    => Exceptions\ContractPriceStartNotDefinedException::class,
        Tokens::NOT_VALID      => Exceptions\ContractPriceStartNotValidException::class,
        Tokens::NOT_AUTHORIZED => Exceptions\ContractPriceStartNotAuthorizedException::class,
        Tokens::NOT_UNIQUE     => Exceptions\ContractPriceStartNotUniqueException::class,
    ];

    /**
     * List of all permissions.
     */
    protected $permissions = [
        Tokens::PERMISSION_FILL => 'contract.attributes.price_start.fill',
        Tokens::PERMISSION_SHOW => 'contract.attributes.price_start.show',
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
        return v::length(1, 255)->validate($value);
    }
}
