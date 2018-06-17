<?php

namespace Railken\LaraOre\Contract\Attributes\PriceEnd;

use Railken\Laravel\Manager\Attributes\BaseAttribute;
use Railken\Laravel\Manager\Contracts\EntityContract;
use Railken\Laravel\Manager\Tokens;
use Respect\Validation\Validator as v;

class PriceEndAttribute extends BaseAttribute
{
    /**
     * Name attribute.
     *
     * @var string
     */
    protected $name = 'price_end';

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
        Tokens::NOT_DEFINED    => Exceptions\ContractPriceEndNotDefinedException::class,
        Tokens::NOT_VALID      => Exceptions\ContractPriceEndNotValidException::class,
        Tokens::NOT_AUTHORIZED => Exceptions\ContractPriceEndNotAuthorizedException::class,
        Tokens::NOT_UNIQUE     => Exceptions\ContractPriceEndNotUniqueException::class,
    ];

    /**
     * List of all permissions.
     */
    protected $permissions = [
        Tokens::PERMISSION_FILL => 'contract.attributes.price_end.fill',
        Tokens::PERMISSION_SHOW => 'contract.attributes.price_end.show',
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
